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

        // Thông tin ngân hàng từ config .env
        $bankName = env('SEPAY_BANK_NAME', 'MSB');
        $bankAccount = env('SEPAY_BANK_ACCOUNT', '968866976549');
        $bankAccountName = env('SEPAY_BANK_ACCOUNT_NAME', 'NGUYENTHITUYETNHU DKMN');
        $bankBin = env('SEPAY_BANK_BIN', '970426');

        // Tạo URL QR VietQR
        // Format: https://img.vietqr.io/image/{bank}-{account}-{template}.png?amount={amount}&addInfo={content}
        $qrUrl = "https://img.vietqr.io/image/{$bankName}-{$bankAccount}-compact.png"
            . "?amount=" . intval($soTien)
            . "&addInfo=" . urlencode($maDonHang)
            . "&accountName=" . urlencode($bankAccountName);

        // Tạo bản ghi ThanhToan với trạng thái chờ
        $thanhToan = ThanhToan::updateOrCreate(
            ['id_dat_tour' => $datTour->id, 'phuong_thuc' => 'bank'],
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
        // 1. Log request payload for audit trail
        Log::info('SePay WebHook - Incoming Request:', [
            'id' => $request->input('id'),
            'gateway' => $request->input('gateway'),
            'amount' => $request->input('transferAmount'),
            'content' => $request->input('content'),
        ]);

        // 2. Validate incoming data
        try {
            $validated = $request->validate([
                'id' => 'required|integer',
                'gateway' => 'required|string',
                'transactionDate' => 'required|string',
                'accountNumber' => 'required|string',
                'transferType' => 'required|string',
                'transferAmount' => 'required|numeric',
                'content' => 'required|string',
                'referenceCode' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('SePay WebHook - Validation Failed:', $e->errors());
            return response()->json(['status' => false, 'message' => 'Validation error'], 422);
        }

        // 3. Signature Verification (Optional but recommended)
        $signature = $request->header('X-Signature');
        $secret = env('SEPAY_WEBHOOK_SECRET');
        if ($signature && $secret) {
            $expectedSignature = hash_hmac('sha256', json_encode($request->all(), JSON_UNESCAPED_UNICODE), $secret);
            if (!hash_equals($expectedSignature, $signature)) {
                Log::warning('SePay WebHook - Invalid Signature Detected');
                return response()->json(['status' => false, 'message' => 'Invalid signature'], 401);
            }
        }

        // 4. Idempotency Check (Prevent duplicate processing)
        $idempotencyKey = $request->header('X-Idempotency-Key') ?? $validated['id'];
        $existingTx = SepayTransaction::where('transaction_id', $validated['id'])
            ->orWhere('webhook_idempotency_key', $idempotencyKey)
            ->first();

        if ($existingTx && $existingTx->trang_thai === 'da_xac_nhan') {
            Log::info('SePay WebHook - Transaction already processed:', ['id' => $validated['id']]);
            return response()->json(['status' => true, 'message' => 'Transaction already processed']);
        }

        // 5. Atomic Transaction Processing
        return \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $idempotencyKey, $existingTx) {
            // Find or Create transaction record
            $sepayTx = $existingTx ?? new SepayTransaction();
            $sepayTx->fill([
                'transaction_id' => $validated['id'],
                'gateway' => $validated['gateway'],
                'account_number' => $validated['accountNumber'],
                'transfer_amount' => $validated['transferAmount'],
                'transfer_type' => $validated['transferType'],
                'content' => $validated['content'],
                'reference_code' => $validated['referenceCode'],
                'transaction_date' => Carbon::parse($validated['transactionDate']),
                'webhook_idempotency_key' => $idempotencyKey,
            ]);

            // Only process incoming transfers
            if (strtolower($validated['transferType']) !== 'in') {
                $sepayTx->trang_thai = 'that_bai';
                $sepayTx->ghi_chu = 'Ignored: Not an incoming transfer';
                $sepayTx->save();
                return response()->json(['status' => true, 'message' => 'Ignored non-incoming transfer']);
            }

            // Extract Order Code from content
            // Hỗ trợ cả format ORDxxx và DTxxx
            $content = $validated['content'];
            $maDonHang = null;
            
            // Thử match nhiều format mã đơn hàng
            $patterns = [
                '/(ORD[0-9A-Z_-]+)/i',   // ORD20260222165001417
                '/(DT\d+)/i',             // DT000001
            ];
            
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $content, $matches)) {
                    $maDonHang = $matches[1];
                    break;
                }
            }
            
            // Fallback: Nếu không match regex, dùng toàn bộ content (trim)
            if (!$maDonHang) {
                $cleanContent = trim($content);
                // Kiểm tra xem content có phải là mã đơn hàng không
                if (DatTour::where('ma_don_hang', $cleanContent)->exists()) {
                    $maDonHang = $cleanContent;
                }
            }
            
            Log::info("SePay WebHook - Content: '{$content}', Extracted order: '{$maDonHang}'");

            if (!$maDonHang) {
                $sepayTx->trang_thai = 'khong_khop';
                $sepayTx->ghi_chu = "No order code found in content: {$content}";
                $sepayTx->save();
                return response()->json(['status' => true, 'message' => 'No order code found']);
            }

            $sepayTx->ma_don_hang = $maDonHang;

            // Find Order
            Log::info("SePay WebHook - Looking for order: {$maDonHang}");
            $datTour = DatTour::where('ma_don_hang', $maDonHang)->first();
            
            if (!$datTour) {
                Log::warning("SePay WebHook - Order not found: {$maDonHang}. Content: {$validated['content']}");
                $sepayTx->trang_thai = 'khong_khop';
                $sepayTx->ghi_chu = "Order not found: {$maDonHang}";
                $sepayTx->save();
                return response()->json(['status' => true, 'message' => 'Received - Order not found']);
            }

            // Amount Validation
            $allowedDelta = (int) env('SEPAY_ALLOWED_DELTA', 2000);
            $expectedAmount = (int) $datTour->tien_thuc_nhan;
            $receivedAmount = (int) $validated['transferAmount'];

            if (abs($receivedAmount - $expectedAmount) > $allowedDelta) {
                $sepayTx->trang_thai = 'khong_khop';
                $sepayTx->ghi_chu = "Amount mismatch: expected {$expectedAmount}, received {$receivedAmount}";
                $sepayTx->save();
                
                $datTour->update(['ghi_chu' => "SePay: Amount mismatch ({$receivedAmount} vs {$expectedAmount})"]);
                
                return response()->json(['status' => false, 'message' => 'Amount mismatch'], 422);
            }

            // Success: Update Order and Payment status
            $datTour->update(['trang_thai' => 'da_thanh_toan']);
            
            ThanhToan::updateOrCreate(
                ['id_dat_tour' => $datTour->id, 'phuong_thuc' => 'bank'],
                [
                    'so_tien' => $receivedAmount,
                    'trang_thai' => 'thanh_cong',
                    'thoi_gian_thanh_toan' => $sepayTx->transaction_date,
                ]
            );

            $sepayTx->trang_thai = 'da_xac_nhan';
            $sepayTx->ghi_chu = 'Payment successful and matched';
            $sepayTx->save();

            Log::info("SePay WebHook - Success: Order {$maDonHang} marked as paid.");

            return response()->json(['status' => true, 'message' => 'Payment processed successfully']);
        });
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
        // Làm sạch mã đơn hàng (loại bỏ gạch chéo cuối nếu có)
        $maDonHang = trim(str_replace('/', '', $maDonHang));
        
        $datTour = DatTour::where('ma_don_hang', $maDonHang)->first();

        if (!$datTour) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }

        $thanhToan = ThanhToan::where('id_dat_tour', $datTour->id)
            ->where('phuong_thuc', 'bank')
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

        $bankName = env('SEPAY_BANK_NAME', 'MSB');
        $bankAccount = env('SEPAY_BANK_ACCOUNT', '968866976549');
        $bankAccountName = env('SEPAY_BANK_ACCOUNT_NAME', 'NGUYENTHITUYETNHU DKMN');
        $bankBin = env('SEPAY_BANK_BIN', '970426');
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
