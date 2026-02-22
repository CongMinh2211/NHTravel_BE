<?php

namespace App\Http\Controllers;

use App\Models\DatTour;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckoutController
{
    private $vnp_TmnCode    = "MUAP6QM1";   // dùng 1 bộ duy nhất
    private $vnp_HashSecret = "XIWHI99518JWD94QL9737ZS6EHYOWXJL";
    private $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

    // Return URL về Laravel
    private $vnp_Returnurl = "https://unmauled-jeannie-nonappendent.ngrok-free.dev/payment/vnpay/return";


    # ===========================================================
    # 1) TẠO LINK THANH TOÁN
    # ===========================================================
    public function vnpay_payment(Request $request)
{
    $data = $request->all();
    
    $vnp_TmnCode = "MUAP6QM1"; 
    $vnp_HashSecret = "XIWHI99518JWD94QL9737ZS6EHYOWXJL";
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    
    // QUAN TRỌNG: Thay link localhost bằng link Ngrok
    $vnp_Returnurl = "https://unmauled-jeannie-nonappendent.ngrok-free.dev/payment/vnpay/return";

    $vnp_TxnRef = $data['ma_don_hang']; // Mã đơn hàng
    $vnp_OrderInfo = "Thanh toan don hang " . $vnp_TxnRef;
    $vnp_OrderType = "billpayment";
    $vnp_Amount = $data['total_vnpay'] * 100;
    $vnp_Locale = "vn";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    

    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    );

    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }

    // Trả về đúng format mà Vue đang đợi
    return response()->json([
        "status" => true,
        "payment_url" => $vnp_Url
    ]);
}

    public function vnpay_return(Request $request)
{
    $vnp_HashSecret = env('VNP_HASH_SECRET');
    $inputData = $request->all();
    
    // Lấy chữ ký từ URL
    $vnp_SecureHash = $inputData['vnp_SecureHash'];
    
    // Xóa các tham số không cần thiết trước khi hash check
    unset($inputData['vnp_SecureHash']);
    unset($inputData['vnp_SecureHashType']);
    
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    // 1. Kiểm tra tính toàn vẹn dữ liệu (Checksum)
    if ($secureHash == $vnp_SecureHash) {
        // Checksum hợp lệ
        
        $orderId = $inputData['vnp_TxnRef'];
        $amount = $inputData['vnp_Amount'] / 100; // Chia lại cho 100 để ra số tiền gốc

        if ($request->vnp_ResponseCode == '00') {
            // --- THANH TOÁN THÀNH CÔNG ---
            
            // TODO: Cập nhật trạng thái đơn hàng trong Database
            // $order = DatTour::find($orderId);
            // $order->status = 'PAID'; 
            // $order->save();

            // Nếu dùng Vue/React tách biệt, hãy redirect về URL frontend kèm tham số
            // return redirect('http://localhost:3000/ket-qua-thanh-toan?status=success&orderId=' . $orderId);
            
            // Nếu dùng Blade Laravel thông thường:
            return view('payment.success', compact('orderId'));
        } else {
            // --- THANH TOÁN THẤT BẠI / HỦY BỎ ---
            
            // return redirect('http://localhost:3000/ket-qua-thanh-toan?status=failed');
            return view('payment.failed');
        }
    } else {
        // Sai chữ ký (Có dấu hiệu giả mạo)
        return response()->json('Chữ ký không hợp lệ', 403);
    }
}






    # ===========================================================
    # 2) RETURN URL – VERIFY CHUẨN!!??
    # ===========================================================

    
//     public function vnpay_return(Request $request)
//     {
//         $inputData = $request->all();
//         $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';

//         unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);
//         ksort($inputData);

//         $hashData = urldecode(http_build_query($inputData));
//         $secureHash = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);

//         if ($secureHash !== $vnp_SecureHash) {
//             return response()->json(["status" => false, "message" => "Sai chữ ký!"]);
//         }

//         if ($inputData['vnp_ResponseCode'] == '00') {
//             return response()->json([
//                 "status" => true,
//                 "message" => "Thanh toán thành công",
//             ]);
//         }

//         return response()->json(["status" => false, "message" => "Thanh toán thất bại"]);
//     }
// }



public function vnpay_ipn(Request $request)
{
    $inputData = $request->all();
    $vnp_HashSecret = env('VNP_HASH_SECRET'); // Lấy từ .env

    $vnp_SecureHash = $inputData['vnp_SecureHash'];
    unset($inputData['vnp_SecureHash']);
    unset($inputData['vnp_SecureHashType']);
    
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }
    
    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    // --- BẮT ĐẦU KIỂM TRA DỮ LIỆU ---
    try {
        // 1. Check Valid Signature (Chữ ký hợp lệ)
        if ($secureHash == $vnp_SecureHash) {
            
            // Lấy thông tin đơn hàng từ DB
            $orderId = $inputData['vnp_TxnRef'];
            $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán
            
            // Tìm đơn hàng trong Database
            // Ví dụ: $order = DatTour::where('id', $orderId)->first();
            // Ở đây mình giả lập biến $order
            $order = \App\Models\DatTour::find($orderId);

            // 2. Check Order Exists (Đơn hàng có tồn tại không)
            if ($order != NULL) {
                
                // 3. Check Order Amount (Số tiền có khớp không)
                // Giả sử trong DB bạn lưu cột 'total_money'
                if ($order->total_money == $vnp_Amount) { 
                    
                    // 4. Check Order Status (Đơn hàng đã xử lý chưa)
                    // Nếu Status = NULL hoặc Pending thì mới xử lý
                    // Nếu đã = Paid rồi thì không làm gì cả (tránh cộng tiền 2 lần)
                    if ($order->status !== 'Success' && $order->status !== 'Canceled') {
                        
                        if ($inputData['vnp_ResponseCode'] == '00') {
                            // --- TRẠNG THÁI THÀNH CÔNG ---
                            $order->status = 'Success'; // Cập nhật trạng thái
                            $order->payment_method = 'VNPAY';
                            $order->save();

                            // (Optional) Tạo bản ghi trong bảng ThanhToan
                            // ThanhToan::create([...]);
                            
                            // Trả về cho VNPAY biết là đã cập nhật thành công
                            return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
                        } else {
                            // --- TRẠNG THÁI THẤT BẠI ---
                            $order->status = 'Failed';
                            $order->save();
                            
                            return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
                        }
                    } else {
                        // Đơn hàng đã được cập nhật trước đó rồi
                        return response()->json(['RspCode' => '02', 'Message' => 'Order already confirmed']);
                    }
                } else {
                    // Số tiền không khớp
                    return response()->json(['RspCode' => '04', 'Message' => 'invalid amount']);
                }
            } else {
                // Không tìm thấy đơn hàng
                return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
            }
        } else {
            // Sai chữ ký
            return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
        }
    } catch (\Exception $e) {
        return response()->json(['RspCode' => '99', 'Message' => 'Unknow error: ' . $e->getMessage()]);
    }
}
}