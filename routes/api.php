<?php

use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChatbotLogController;
use App\Http\Controllers\ChiTietTourController;
use App\Http\Controllers\ChucNangController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DanhMucBaiVietController;
use App\Http\Controllers\DanhMucController;

use App\Http\Controllers\DatTourController;
use App\Http\Controllers\HomeCustomerController;
use App\Http\Controllers\LichSuDHController;
use App\Http\Controllers\MaGiamGiaController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\PhanQuyenController;
use App\Http\Controllers\PhuongTienController;
use App\Http\Controllers\ThongTinLienHeController;
use App\Http\Controllers\TourDuLichController;
use App\Http\Controllers\TourPhuongTienController;
use App\Http\Controllers\TrangChuController;
use App\Models\NguoiDung;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//admin danh mục
Route::get('admin/danh-muc-tour/get-data', [DanhMucController::class, 'getData']);
Route::post('admin/danh-muc-tour/add-data', [DanhMucController::class, 'addData']);
Route::post('admin/danh-muc-tour/update', [DanhMucController::class, 'update']);
Route::post('admin/danh-muc-tour/delete', [DanhMucController::class, 'destroy']);
Route::post('admin/danh-muc-tour/tim-kiem', [DanhMucController::class, 'search']);





// // Logout
// Route::middleware('auth:sanctum')->post('/logout', [NguoiDungController::class, 'logout']);
//Phuong Tien
Route::get('/admin/phuong-tien/get-data', [PhuongTienController::class, 'getData']);
Route::post('/admin/phuong-tien/add-data', [PhuongTienController::class, 'addData']);
Route::post('/admin/phuong-tien/update', [PhuongTienController::class, 'upDate']);
Route::post('/admin/phuong-tien/delete', [PhuongTienController::class, 'destroy']);
Route::post('/admin/phuong-tien/chang-status', [PhuongTienController::class, 'changeStatus']);
//Tour Phuong Tien
Route::get('/admin/tour-pt/get-data', [TourPhuongTienController::class, 'getData']);
Route::post('/admin/tour-pt/add-data', [TourPhuongTienController::class, 'addData']);
Route::post('/admin/tour-pt/update', [TourPhuongTienController::class, 'upDate']);
Route::post('/admin/tour-pt/delete', [TourPhuongTienController::class, 'destroy']);
Route::get('/admin/tour-pt/get-by-pt/{id}', [TourPhuongTienController::class, 'getByPhuongTien']);


//Voucher
Route::get('/admin/ma-giam-gia/get-data', [MaGiamGiaController::class, 'getData']);
Route::post('/admin/ma-giam-gia/add-data', [MaGiamGiaController::class, 'addData']);
Route::post('/admin/ma-giam-gia/update', [MaGiamGiaController::class, 'update']);
Route::post('/admin/ma-giam-gia/delete', [MaGiamGiaController::class, 'destroy']);
Route::post('/admin/ma-giam-gia/change-status', [MaGiamGiaController::class, 'changeStatus']);
Route::post('/admin/ma-giam-gia/tim-kiem', [MaGiamGiaController::class, 'findmaGiamGia']);



//QL Booking Tour
Route::get('/admin/chi-tiet-dat-tour/get-data', [DatTourController::class, 'getData']);
Route::post('/admin/dat-tour/delete', [DatTourController::class, 'destroy']);
Route::post('/admin/dat-tour/change-status', [DatTourController::class, 'changeStatus']);
Route::post('/admin/dat-tour/loc-thong-tin', [DatTourController::class, 'locThongTin']);

// PHAN QUYEN :
Route::get('/admin/phan-quyen/chuc-nang/get-data', [ChucNangController::class, 'getData']);
Route::post('/admin/phan-quyen/chi-tiet-phan-quyen/add-data', [PhanQuyenController::class, 'themPhanQuyen']);
Route::post('/admin/phan-quyen/chi-tiet-phan-quyen/delete', [PhanQuyenController::class, 'xoaPhanQuyen']);
Route::post('/admin/phan-quyen/chi-tiet-phan-quyen/get-data', [PhanQuyenController::class, 'getChiTietPhanQuyen']);
// Chức vụ
Route::get('/admin/chuc-vu/get-data', [ChucVuController::class, 'getData']);
Route::post('/admin/chuc-vu/add-data', [ChucVuController::class, 'addData']);
Route::post('/admin/chuc-vu/update', [ChucVuController::class, 'update']);
Route::post('/admin/chuc-vu/delete', [ChucVuController::class, 'destroy']);
Route::post('/admin/chuc-vu/change-status', [ChucVuController::class, 'changeStatus']);
Route::post('/admin/chuc-vu/tim-kiem', [ChucVuController::class, 'search']);


// Bình luận
Route::get('/admin/binh-luan/get-data', [DanhGiaController::class, 'getData']);
Route::post('/admin/binh-luan/delete', [DanhGiaController::class, 'destroy']);
Route::post('/admin/binh-luan/tim-kiem', [DanhGiaController::class, 'search']);
Route::post('/admin/binh-luan/phan-hoi', [DanhGiaController::class, 'phanHoi']);


//Khách hàng liên hệ 
Route::post('/admin/lien-he/guiThongTin', [ThongTinLienHeController::class, 'guiThongTin']);
//admin liên hệ
Route::get('/admin/lien-he/get-data', [ThongTinLienHeController::class, 'getData']);
Route::post('/admin/lien-he/delete', [ThongTinLienHeController::class, 'destroy']);
Route::post('/admin/lien-he/change-status', [ThongTinLienHeController::class, 'changeStatus']);




// Tài khoản người dùng

// Check token (cần auth:sanctum)
Route::middleware('auth:sanctum')->get('/check-token', [NguoiDungController::class, 'checkToken']);
// Login chung cho tất cả role
Route::post('/dang-nhap', [NguoiDungController::class, 'dangNhap']);
Route::post('/dang-ky', [NguoiDungController::class, 'danhKy']);
Route::post('/kich-hoat', [NguoiDungController::class, 'kichHoat']);
Route::get('/thong-tin', [NguoiDungController::class, 'thongTinNguoiDung']);
//Route::post('/dang-xuat', [NguoiDungController::class, 'dangXuat']);
Route::middleware('auth:sanctum')->post('/dang-xuat', [NguoiDungController::class, 'dangXuat']);

//thêm tour
Route::middleware('auth:sanctum')->post('/admin/them-tour', [TourDuLichController::class, 'themTour']);
Route::middleware('auth:sanctum')->get('/admin/tour/get-data', [TourDuLichController::class, 'danhSachTour']);
Route::middleware('auth:sanctum')->get('/admin/tour/{id}', [TourDuLichController::class, 'chiTietTour']);
Route::middleware('auth:sanctum')->post('/admin/tour/update/{id}', [TourDuLichController::class, 'capNhatTour']);
Route::middleware('auth:sanctum')->delete('/admin/tour/delete/{id}', [TourDuLichController::class, 'xoaTour']);



//trang chủ admin
Route::middleware('auth:sanctum')->get('/admin/dashboard', [TrangChuController::class, 'tongDuLieu']);
Route::middleware('auth:sanctum')->get('/admin/doanh-thu-ngay', [TrangChuController::class, 'doanhThuTheoNgay']);
Route::middleware('auth:sanctum')->get('/admin/thong-ke-doanh-thu', [TrangChuController::class, 'thongKeDoanhThuTheoThang']);
Route::middleware('auth:sanctum')->get('/admin/top-tour-thang', [TrangChuController::class, 'topTourTheoThang']);
//người dùng
Route::middleware('auth:sanctum')->get('/admin/nguoi-dung', [NguoiDungController::class, 'getNguoiDung']);
Route::middleware('auth:sanctum')->get('/admin/nguoi-dung/chi-tiet-nguoi-dung', [NguoiDungController::class, 'chiTietNguoiDung']);
Route::middleware('auth:sanctum')->post('/admin/nguoi-dung/them-nguoi-dung', [NguoiDungController::class, 'themNguoiDung']);
Route::middleware('auth:sanctum')->post('/admin/nguoi-dung/sua-nguoi-dung', [NguoiDungController::class, 'suaNguoiDung']);
Route::middleware('auth:sanctum')->post('/admin/nguoi-dung/xoa-nguoi-dung', [NguoiDungController::class, 'xoaNguoiDung']);
Route::post('/admin/nguoi-dung/tim-kiem', [NguoiDungController::class, 'timKiem']);
// =========================================================
// ======================= CLIENT ==========================
// =========================================================

// TRANG CHU
Route::get('/home-page', [HomeCustomerController::class, 'homepageData']);
Route::get('/danh-gia', [HomeCustomerController::class, 'getDanhGia']);

Route::prefix('customer')->group(function () {

    // Tour Du Lịch
    Route::get('/tour/get-data', [TourDuLichController::class, 'getlistCustomer']);

    // Chi Tiết Tour
    Route::post('/chi-tiet-tour/get-data', [ChiTietTourController::class, 'getDataTour']);

    // Đặt Tour
    Route::post('/chi-tiet-dat-tour/get-data', [DatTourController::class, 'getDatTour']);
    Route::post('/dat-tour/tinh-tien', [DatTourController::class, 'tinhTien']);
    Route::post('/dat-tour/dat', [DatTourController::class, 'store']);

    // Voucher
    Route::get('/voucher/list', [MaGiamGiaController::class, 'getVoucher']);

    // Lịch Sử Đơn Hàng
    Route::middleware('auth:sanctum')->get('/ls-dat-tour/list', [LichSuDHController::class, 'getData']);



    // BINH LUAN
    Route::middleware('auth:sanctum')->post(
        '/chi-tiet-tour/binh-luan',
        [DanhGiaController::class, 'binhLuantour']
    );
    Route::get('/chi-tiet-tour/binh-luan/get-data/{id}', [DanhGiaController::class, 'getDataCustomerBinhLuan']);
    Route::get('/chi-tiet-tour/diem-trung-binh/{id_tour}', [DanhGiaController::class, 'getDiemTrungBinh']);

    // Chi tiết bài viết
    Route::get('bai-viet/{id}/related', [BaiVietController::class, 'related']);
    Route::apiResource('bai-viet', BaiVietController::class);
    Route::apiResource('danh-muc-bai-viet', DanhMucBaiVietController::class);
 

    // Hồ sơ cá nhân
    Route::middleware('auth:sanctum')->post('/profile/update', [NguoiDungController::class, 'capNhatThongTin']);
    Route::middleware('auth:sanctum')->post('/profile/change-password', [NguoiDungController::class, 'doiMatKhau']);

});

// ===================== VNPay ===============================
Route::post('/payment/vnpay/create', [CheckoutController::class, 'vnpay_payment']);
Route::get('/payment/vnpay/return', [CheckoutController::class, 'vnpay_return']);
// Route::get('/payment/vnpay/ipn', [CheckoutController::class, 'vnpay_ipn']);
Route::get('/vnpay/ipn', [CheckoutController::class, 'vnpay_ipn']);

// ===================== SePay ===============================
use App\Http\Controllers\SepayController;
use App\Http\Controllers\SepayTransactionController;

Route::post('/payment/sepay/create', [SepayController::class, 'createPayment']);
Route::get('/payment/sepay/status/{ma_don_hang}', [SepayController::class, 'checkStatus']);
Route::get('/payment/sepay/qr/{ma_don_hang}', [SepayController::class, 'getQrCode']);

// Webhook endpoint (SePay sẽ gọi đến đây khi có giao dịch)
Route::post('/webhook/sepay', [SepayController::class, 'handleWebhook']);

// SePay Transactions API (cho admin)
Route::get('/sepay/transactions', [SepayTransactionController::class, 'index']);
Route::get('/sepay/transactions/{id}', [SepayTransactionController::class, 'show']);
Route::get('/sepay/statistics', [SepayTransactionController::class, 'statistics']);

// Suggest Tour
Route::get('/tour-suggest', [HomeCustomerController::class, 'suggestTour']);

// ===================== CHATBOT ===========================
// Public endpoints (không cần authentication)
Route::post('/chatbot/ask', [ChatbotLogController::class, 'askQuestion']);

// Protected endpoints (cần authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/chatbot/history/{userId}', [ChatbotLogController::class, 'getHistory']);
    Route::post('/chatbot/send-message', [ChatbotLogController::class, 'sendMessage']);
    Route::delete('/chatbot/clear-history/{userId}', [ChatbotLogController::class, 'clearHistory']);
});

// ===================== HEALTHCHECK =========================
// Endpoint cho Railway healthcheck
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API is running',
        'timestamp' => now()->toIso8601String()
    ]);
});

// Admin endpoints
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/chatbot/logs', [ChatbotLogController::class, 'index']);
    Route::delete('/admin/chatbot/logs/{id}', [ChatbotLogController::class, 'destroy']);
});