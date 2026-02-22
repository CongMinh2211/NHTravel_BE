<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use App\Mail\MasterMail;
use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;



class NguoiDungController
{

    public function dangNhap(Request $request)
    {


        // Tìm user theo email và password
        $user = NguoiDung::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Thông tin đăng nhập không chính xác.'
            ], 401);
        }

        // Kiểm tra trạng thái tài khoản
        if ($user->trang_thai !== 'active') {

            // Tạo lại hash_active mới để gửi mail kích hoạt
            $key = Str::uuid();
            $user->update(['hash_active' => $key]);

            // Gửi mail kích hoạt
            $tieu_de = "Kích hoạt tài khoản";
            $view = "kichHoatTK";
            $noi_dung['ho_ten'] = $user->ho_ten;
            $noi_dung['link'] = "http://localhost:5173/kich-hoat/" . $key;
            Mail::to($user->email)->send(new MasterMail($tieu_de, $view, $noi_dung));

            return response()->json([
                'status' => false,
                'message' => 'Tài khoản chưa được kích hoạt. Chúng tôi đã gửi lại email kích hoạt, vui lòng kiểm tra hộp thư của bạn.'
            ], 403);
        }

        // Tạo token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'ho_ten' => $user->ho_ten,
                'id_chuc_vu' => $user->id_chuc_vu,
                'email' => $user->email
            ]
        ]);
    }

    // Kiểm tra token
    public function checkToken(Request $request)
    {
        //$user = Auth::guard('sanctum')->user();
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Token không hợp lệ'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'user' => [
                'id' => $user->id,
                'ho_ten' => $user->ho_ten,
                'id_chuc_vu' => $user->id_chuc_vu,
                'email' => $user->email
            ]
        ]);
    }



    // Đăng ký người dùng
    public function danhKy(Request $request)
    {

        $key = Str::uuid();
        $user = NguoiDung::create([
            'ho_ten' => $request->ho_ten,
            'email'    => $request->email,
            'password' => $request->password,
            'cccd' => $request->cccd,
            'so_dien_thoai' => $request->so_dien_thoai,
            'ngay_sinh' => $request->ngay_sinh,
            'id_chuc_vu' => 3,
            'trang_thai' => 'inactive',
            'hash_active'   => $key,

        ]);

        $tieu_de = "Kích hoạt tài khoản";
        $view = "kichHoatTK";
        $noi_dung['ho_ten'] = $user->ho_ten;
        $noi_dung['link'] = "http://localhost:5173/kich-hoat/" . $key;
        Mail::to($request->email)->send(new MasterMail($tieu_de, $view, $noi_dung));

        return response()->json([
            'status' => true,
            'message' => 'Đăng ký thành công!',
            'data' => $user
        ]);
    }

    // kích hoạt người dùng
    public function kichHoat(Request $request)
    {
        $user = NguoiDung::where('hash_active', $request->hash_active)->update([
            'trang_thai' => 'active',
            'hash_active' => null
        ]);
        return response()->json([
            'status'    =>  1,
            'message'   =>  'Đã kích hoạt tài khoản thành công'
        ]);
    }

    // thông tin người dùng
    public function thongTinNguoiDung()
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            return response()->json([
                'status' => 1,
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => "Token không hợp lệ"
        ], 401);
    }



    // Logout chung cho tất cả user/admin
    public function dangXuat(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Đăng xuất thành công'
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Token không hợp lệ'], 401);
    }

    //ql tài khoản
    public function getNguoiDung(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        // Lấy tất cả người dùng + chức vụ
        $data = NguoiDung::with('chucVu:id,ten_chuc_vu')->get();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách người dùng thành công',
            'data' => $data
        ]);
    }
    public function chiTietNguoiDung(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        $data = NguoiDung::with('chucVu:id,ten_chuc_vu')->find($request->id);

        // Không tìm thấy
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng'
            ], 404);
        }

        // Trả về đúng format chung của bạn
        return response()->json([
            'status' => true,
            'message' => 'Lấy chi tiết người dùng thành công',
            'data' => $data
        ]);
    }

    public function themNguoiDung(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        $user = NguoiDung::create([
            'ho_ten'        => $request->ho_ten,
            'email'         => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'ngay_sinh'     => $request->ngay_sinh,
            'cccd'          => $request->cccd,
            'id_chuc_vu'    => $request->id_chuc_vu,
            'trang_thai'    => $request->trang_thai,
            'password'      => $request->password,
            'avatar'        => $request->avatar,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Thêm người dùng ' . $request->ho_ten . ' thành công!',
            'data' => $user
        ]);
    }

    public function suaNguoiDung(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        $nguoiDung = NguoiDung::find($request->id);

        if (!$nguoiDung) {
            return response()->json(['status' => 0, 'message' => 'Người dùng không tồn tại']);
        }

        // Cập nhật thông tin, password lưu thẳng
        $nguoiDung->update([
            'ho_ten'        => $request->ho_ten,
            'email'         => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'ngay_sinh'     => $request->ngay_sinh,
            'cccd'          => $request->cccd,
            'id_chuc_vu'    => $request->id_chuc_vu,
            'trang_thai'    => $request->trang_thai,
            'password'      => $request->password,
            'avatar'        => $request->avatar,
        ]);

        // Load lại user kèm thông tin chức vụ
        $nguoiDung = NguoiDung::with('chucVu:id,ten_chuc_vu')->find($request->id);

        return response()->json([
            'status'  => true,
            'message' => 'Cập nhật người dùng thành công!',
            'data'    => $nguoiDung
        ]);
    }

    public function xoaNguoiDung(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        NguoiDung::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa danh người dùng ' . $request->ho_ten . ' thành công',
        ]);
    }

    // public function timKiem(Request $request)
    // {
    //     $keyword  = '%' . $request->ho_ten . '%';

    //     $data = NguoiDung::where('ho_ten', 'like', $keyword)
    //         ->orWhere('email', 'like', $keyword)
    //         ->orWhere('so_dien_thoai', 'like', $keyword)
    //         ->get();

    //     return response()->json([
    //         'data' => $data
    //     ]);
    // }
    public function timKiem(Request $request)
    {
        $keyword = $request->input('tim_nguoi_dung', '');

        $query = NguoiDung::query();
        $query = NguoiDung::with('chucVu:id,ten_chuc_vu'); // load quan hệ chucVu
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('ho_ten', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('so_dien_thoai', 'like', "%{$keyword}%");
            });
        }

        $data = $query->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
