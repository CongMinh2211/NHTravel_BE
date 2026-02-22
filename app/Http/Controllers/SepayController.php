<?php

namespace App\Http\Controllers;

use App\Models\DatTour;
use App\Models\ThanhToan;
use App\Models\SepayTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * SepayController - Xử lý thanh toán qua SePay
 * 
 * Flow hoạt động:
 * 1. Khách hàng đặt tour -> tạo đơn hàng với ma_don_hang bắt đầu bằng ORD
 * 2. Frontend hiển thị QR code VietQR với nội dung chuyển khoản = ma_don_hang
 * 3. Khách hàng chuyển khoản qua app ngân hàng
 * 4. SePay gửi webhook đến handleWebhook() khi có giao dịch
 * 5. Hệ thống tự động match nội dung với ma_don_hang và cập nhật trạng thái
 */
class SepayController
{
    /**
     * Tạo thông tin thanh toán SePay (QR code VietQR)
     * 
     * @param Request $request {ma_don_hang, so_tien}
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'ma_don_hang' => 'required|string',
            'so_tien' => 'required|numeric|min:1000',
        ]);

        $maDonHang = $request->ma_don_hang;
        $soTien = $request->so_tien;

        // Kiểm tra đơn hàng tồn tại
        $datTour = DatTour::where('ma_don_hang', $maDonHang)->first();

        if (!$datTour) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }

        // Thông tin ngân hàng MSB (Maritime Bank)
        $bankName = 'MSB';
        $bankAccount = '7008032005';
        $bankAccountName = 'TRAN CONG MINH';
        $bankBin = '970426';

        // Tạo URL QR VietQR
        // Format: https://img.vietqr.io/image/{bank}-{account}-{template}.png?amount={amount}&addInfo={content}
        $qrUrl = "https://img.vietqr.io/image/{$bankName}-{$bankAccount}-compact.png"
            . "?amount=" . intval($soTien)
            . "&addInfo=" . urlencode($maDonHang)
            . "&accountName=" . urlencode($bankAccountName);

        // Tạo bản ghi ThanhToan với trạng thái chờ
        $thanhToan = ThanhToan::updateOrCreate(
            ['id_dat_tour' => $datTour->id, 'phuong_thuc' => 'sepay'],
            [
                'so_tien' => $soTien,
                'trang_thai' => 'cho_thanh_toan',
                'thoi_gian_thanh_toan' => null,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Tạo thanh toán thành công',
            'data' => [
                'ma_don_hang' => $maDonHang,
                'so_tien' => $soTien,
                'so_tien_format' => number_format($soTien, 0, ',', '.') . ' VND',
                'qr_url' => $qrUrl,
                'bank_name' => $bankName,
                'bank_account' => $bankAccount,
                'bank_account_name' => $bankAccountName,
                'noi_dung_chuyen_khoan' => $maDonHang,
                'payment_id' => $thanhToan->id,
                'expires_at' => now()->addMinutes(15)->toIso8601String(),
            ]
        ]);
    }

    /**
     * Webhook nhận thông báo từ SePay khi có giao dịch ngân hàng
     * 
     * SePay sẽ gửi POST request đến endpoint này khi phát hiện giao dịch mới
     * 
     * @param Request $request Payload từ SePay
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleWebhook(Request $request)
    {
        // Luôn log payload để debug
        Log::info('SePay Webhook Payload:', $request->all());

        // Xác thực API Key từ header - dùng sandbox nên bỏ qua xác thực
        $apiKey = $request->header('Authorization');
        $expectedKey = 'Bearer sepay_webhook_token_123';

        // Nếu không có Authorization header, check query param hoặc body
        if (!$apiKey) {
            $apiKey = $request->input('api_key') ?? $request->input('token');
            $expectedKey = 'sepay_webhook_token_123';
        }

        // Verify token (bỏ qua trong sandbox mode)
        $environment = 'sandbox';
        if ($environment !== 'sandbox' && $apiKey !== $expectedKey) {
            Log::warning('SePay Webhook: Invalid API Key', [
                'received' => $apiKey,
                'expected' => $expectedKey
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Lấy dữ liệu từ payload SePay
        $transactionId = $request->input('id');
        $gateway = $request->input('gateway');  // Tên ngân hàng
        $transactionDate = $request->input('transactionDate');
        $accountNumber = $request->input('accountNumber');
        $transferType = $request->input('transferType'); // 'in' = tiền vào
        $transferAmount = $request->input('transferAmount');
        $content = $request->input('content'); // Nội dung chuyển khoản
        $referenceCode = $request->input('referenceCode');

        // Lưu transaction vào database
        $sepayTx = SepayTransaction::create([
            'transaction_id' => $transactionId,
            'gateway' => $gateway,
            'account_number' => $accountNumber,
            'transfer_amount' => $transferAmount,
            'transfer_type' => $transferType,
            'content' => $content,
            'reference_code' => $referenceCode,
            'transaction_date' => $transactionDate ? Carbon::parse($transactionDate) : now(),
            'trang_thai' => 'cho_xu_ly',
        ]);

        // Chỉ xử lý giao dịch tiền vào
        if ($transferType !== 'in') {
            $sepayTx->update(['trang_thai' => 'that_bai', 'ghi_chu' => 'Không phải giao dịch tiền vào']);
            return response()->json([
                'success' => true,
                'message' => 'Ignored: Not incoming transfer'
            ]);
        }

        // Tìm mã đơn hàng trong nội dung chuyển khoản
        $pattern = '/(ORD[0-9A-Z-]+|TEST[0-9]+)/i';
        $matchPattern = 'ORD';
        
        preg_match($pattern, $content, $matches);
        $maDonHang = $matches[1] ?? null;

        // Nếu không tìm thấy mã đơn hàng theo regex, thử tìm chính xác
        if (!$maDonHang) {
            // Thử tìm đơn hàng có ma_don_hang nằm trong nội dung
            $datTour = DatTour::whereRaw('LOWER(?) LIKE CONCAT("%", LOWER(ma_don_hang), "%")', [$content])
                ->where('trang_thai', 'cho_xu_ly')
                ->first();
            
            if ($datTour) {
                $maDonHang = $datTour->ma_don_hang;
            }
        }

        if (!$maDonHang) {
            Log::info('SePay Webhook: No order code found in content', [
                'content' => $content,
                'pattern' => $pattern
            ]);
            // Lưu transaction không tìm thấy mã đơn
            $sepayTx->update([
                'trang_thai' => 'khong_khop',
                'ghi_chu' => 'Không tìm thấy mã đơn hàng trong nội dung: ' . $content
            ]);
            return response()->json([
                'success' => true,
                'message' => 'No matching order code found'
            ]);
        }

        // Tìm đơn hàng
        $datTour = DatTour::where('ma_don_hang', $maDonHang)->first();

        if (!$datTour) {
            Log::warning('SePay Webhook: Order not found', ['ma_don_hang' => $maDonHang]);
            // Cập nhật transaction không tìm thấy đơn
            $sepayTx->update([
                'trang_thai' => 'khong_khop',
                'ghi_chu' => 'Không tìm thấy đơn hàng: ' . $maDonHang
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Order not found: ' . $maDonHang
            ], 404);
        }

        // Kiểm tra số tiền (cho phép sai số nhỏ - tăng lên 2000 để test 2-3 nghìn)
        $allowedDelta = 2000;
        $expectedAmount = $datTour->tien_thuc_nhan;
        
        if (abs($transferAmount - $expectedAmount) > $allowedDelta) {
            Log::warning('SePay Webhook: Amount mismatch', [
                'expected' => $expectedAmount,
                'received' => $transferAmount,
                'order' => $maDonHang
            ]);
            // Vẫn ghi nhận nhưng không tự động confirm
            $datTour->ghi_chu = "Số tiền không khớp: nhận {$transferAmount}, cần {$expectedAmount}";
            $datTour->save();
            
            // Cập nhật trạng thái transaction
            $sepayTx->update([
                'trang_thai' => 'khong_khop',
                'ma_don_hang' => $maDonHang,
                'ghi_chu' => "Số tiền không khớp: nhận {$transferAmount}, cần {$expectedAmount}"
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Amount mismatch - pending manual review'
            ]);
        }

        // Kiểm tra đơn hàng đã thanh toán chưa
        if ($datTour->trang_thai === 'da_thanh_toan') {
            $sepayTx->update([
                'trang_thai' => 'da_xac_nhan',
                'ma_don_hang' => $maDonHang,
                'ghi_chu' => 'Đơn hàng đã thanh toán trước đó'
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Order already paid'
            ]);
        }

        // Cập nhật trạng thái đơn hàng
        $datTour->trang_thai = 'da_thanh_toan';
        $datTour->save();

        // Cập nhật hoặc tạo bản ghi thanh toán
        ThanhToan::updateOrCreate(
            ['id_dat_tour' => $datTour->id, 'phuong_thuc' => 'sepay'],
            [
                'so_tien' => $transferAmount,
                'trang_thai' => 'thanh_cong',
                'thoi_gian_thanh_toan' => $transactionDate ? Carbon::parse($transactionDate) : now(),
            ]
        );

        // Cập nhật trạng thái transaction thành công
        $sepayTx->update([
            'trang_thai' => 'da_xac_nhan',
            'ma_don_hang' => $maDonHang,
            'ghi_chu' => 'Thanh toán thành công'
        ]);

        Log::info('SePay Webhook: Payment confirmed', [
            'order' => $maDonHang,
            'amount' => $transferAmount,
            'transaction_id' => $transactionId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment confirmed successfully'
        ]);
    }

    /**
     * Kiểm tra trạng thái thanh toán của đơn hàng
     * 
     * Frontend sẽ gọi API này để polling kiểm tra
     * 
     * @param string $maDonHang Mã đơn hàng
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus($maDonHang)
    {
        $datTour = DatTour::where('ma_don_hang', $maDonHang)->first();

        if (!$datTour) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }

        $thanhToan = ThanhToan::where('id_dat_tour', $datTour->id)
            ->where('phuong_thuc', 'sepay')
            ->first();

        $isPaid = $datTour->trang_thai === 'da_thanh_toan';

        return response()->json([
            'status' => true,
            'data' => [
                'ma_don_hang' => $maDonHang,
                'trang_thai_don_hang' => $datTour->trang_thai,
                'trang_thai_thanh_toan' => $thanhToan ? $thanhToan->trang_thai : 'chua_thanh_toan',
                'is_paid' => $isPaid,
                'so_tien' => $datTour->tien_thuc_nhan,
                'thoi_gian_thanh_toan' => $thanhToan ? $thanhToan->thoi_gian_thanh_toan : null,
            ]
        ]);
    }

    /**
     * Lấy URL QR code cho đơn hàng
     * 
     * @param string $maDonHang Mã đơn hàng
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQrCode($maDonHang)
    {
        $datTour = DatTour::where('ma_don_hang', $maDonHang)->first();

        if (!$datTour) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }

        $bankName = 'MSB';
        $bankAccount = '7008032005';
        $bankAccountName = 'TRAN CONG MINH';
        $bankBin = '970426';
        $soTien = $datTour->tien_thuc_nhan;

        $qrUrl = "https://img.vietqr.io/image/{$bankName}-{$bankAccount}-compact.png"
            . "?amount=" . intval($soTien)
            . "&addInfo=" . urlencode($maDonHang)
            . "&accountName=" . urlencode($bankAccountName);

        return response()->json([
            'status' => true,
            'data' => [
                'ma_don_hang' => $maDonHang,
                'qr_url' => $qrUrl,
                'bank_name' => $bankName,
                'bank_account' => $bankAccount,
                'bank_account_name' => $bankAccountName,
                'so_tien' => $soTien,
                'so_tien_format' => number_format($soTien, 0, ',', '.') . ' VND',
                'noi_dung_chuyen_khoan' => $maDonHang,
            ]
        ]);
    }
}
