<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use App\Mail\MasterMail;
use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class NguoiDungController
{

    public function dangNhap(Request $request)
    {


        // Tìm user theo email
        $user = NguoiDung::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Thông tin đăng nhập không chính xác.'
            ], 401);
        }

        // Kiểm tra mật khẩu - hỗ trợ cả plain text và hashed password
        $passwordValid = false;
        if ($user->password && strlen($user->password) >= 60) {
            // Nếu password trong DB có vẻ là hash (BCrypt >= 60 ký tự), dùng Hash::check
            $passwordValid = Hash::check($request->password, $user->password);
        } else {
            // So sánh trực tiếp cho plain text
            $passwordValid = ($user->password === $request->password);
        }

        if (!$passwordValid) {
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
            $noi_dung['link'] = "https://nh-travel-three.vercel.app/kich-hoat/" . $key;
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
        try {
            $request->validate([
                'ho_ten'        => 'required|string|max:255',
                'email'         => 'required|email|unique:nguoi_dungs,email',
                'password'      => 'required|min:6',
                'cccd'          => 'required|unique:nguoi_dungs,cccd',
                'so_dien_thoai' => 'required',
            ], [
                'ho_ten.required' => 'Họ tên không được để trống.',
                'email.required'  => 'Email không được để trống.',
                'email.email'     => 'Email không đúng định dạng.',
                'email.unique'    => 'Email này đã được sử dụng.',
                'password.required' => 'Mật khẩu không được để trống.',
                'password.min'    => 'Mật khẩu phải ít nhất 6 ký tự.',
                'cccd.required'   => 'Số CCCD không được để trống.',
                'cccd.unique'     => 'Số CCCD này đã được sử dụng.',
                'so_dien_thoai.required' => 'Số điện thoại không được để trống.',
            ]);

            $key = Str::uuid();
            $user = NguoiDung::create([
                'ho_ten'        => $request->ho_ten,
                'email'         => $request->email,
                'password'      => Hash::make($request->password), // Đã mã hóa mật khẩu
                'cccd'          => $request->cccd,
                'so_dien_thoai' => $request->so_dien_thoai,
                'ngay_sinh'     => $request->ngay_sinh,
                'id_chuc_vu'    => 3, // Mặc định là khách hàng
                'trang_thai'    => 'inactive',
                'hash_active'   => $key,
            ]);

            $tieu_de = "Kích hoạt tài khoản";
            $view = "kichHoatTK";
            $noi_dung['ho_ten'] = $user->ho_ten;
            // Thay đổi localhost thành URL Production của Vercel
            $noi_dung['link'] = "https://nh-travel-three.vercel.app/kich-hoat/" . $key;
            
            try {
                Mail::to($user->email)->send(new MasterMail($tieu_de, $view, $noi_dung));
            } catch (\Exception $e) {
                // Nếu lỗi mail (do chưa cấu hình SMTP trên Railway), vẫn để user được tạo
                // nhưng báo cho họ biết hoặc có thể set active luôn nếu cần.
            }

            return response()->json([
                'status' => true,
                'message' => 'Đăng ký thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.',
                'data' => $user
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra trong quá trình đăng ký: ' . $e->getMessage()
            ], 500);
        }
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
        try {
            $request->validate([
                'ho_ten'        => 'required|string|max:255',
                'email'         => 'required|email|unique:nguoi_dungs,email',
                'password'      => 'required|min:6',
                'id_chuc_vu'    => 'required|exists:chuc_vus,id',
                'cccd'          => 'nullable|unique:nguoi_dungs,cccd',
            ], [
                'ho_ten.required' => 'Họ tên không được để trống.',
                'email.required'  => 'Email không được để trống.',
                'email.email'     => 'Email không đúng định dạng.',
                'email.unique'    => 'Email đã tồn tại trong hệ thống.',
                'password.required' => 'Mật khẩu không được để trống.',
                'password.min'    => 'Mật khẩu phải từ 6 ký tự trở lên.',
                'id_chuc_vu.required' => 'Vui lòng chọn chức vụ.',
                'id_chuc_vu.exists' => 'Chức vụ không hợp lệ.',
                'cccd.unique'     => 'Số CCCD đã tồn tại trong hệ thống.',
            ]);

            $user = NguoiDung::create([
                'ho_ten'        => $request->ho_ten,
                'email'         => $request->email,
                'so_dien_thoai' => $request->so_dien_thoai,
                'ngay_sinh'     => $request->ngay_sinh,
                'cccd'          => $request->cccd,
                'id_chuc_vu'    => $request->id_chuc_vu,
                'trang_thai'    => $request->trang_thai ?? 'active',
                'password'      => Hash::make($request->password),
                'avatar'        => $request->avatar,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Thêm người dùng ' . $request->ho_ten . ' thành công!',
                'data' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function suaNguoiDung(Request $request)
    {
        try {
            $nguoiDung = NguoiDung::find($request->id);

            if (!$nguoiDung) {
                return response()->json(['status' => false, 'message' => 'Người dùng không tồn tại'], 404);
            }

            $request->validate([
                'ho_ten'        => 'required|string|max:255',
                'email'         => 'required|email|unique:nguoi_dungs,email,' . $request->id,
                'id_chuc_vu'    => 'required|exists:chuc_vus,id',
                'cccd'          => 'nullable|unique:nguoi_dungs,cccd,' . $request->id,
            ], [
                'ho_ten.required' => 'Họ tên không được để trống.',
                'email.unique'    => 'Email này đã được người khác sử dụng.',
                'cccd.unique'     => 'CCCD này đã được người khác sử dụng.',
            ]);

            $nguoiDung->update([
                'ho_ten'        => $request->ho_ten,
                'email'         => $request->email,
                'so_dien_thoai' => $request->so_dien_thoai,
                'ngay_sinh'     => $request->ngay_sinh,
                'cccd'          => $request->cccd,
                'id_chuc_vu'    => $request->id_chuc_vu,
                'trang_thai'    => $request->trang_thai,
                'password'      => $request->password ? Hash::make($request->password) : $nguoiDung->password,
                'avatar'        => $request->avatar,
            ]);

            $nguoiDung = NguoiDung::with('chucVu:id,ten_chuc_vu')->find($request->id);

            return response()->json([
                'status'  => true,
                'message' => 'Cập nhật người dùng thành công!',
                'data'    => $nguoiDung
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
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

    public function capNhatThongTin(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Bạn chưa đăng nhập!'], 401);
        }

        $request->validate([
            'ho_ten'        => 'required|string|max:255',
            'email'         => 'required|email|unique:nguoi_dungs,email,' . $user->id,
            'so_dien_thoai' => 'nullable|string',
            'ngay_sinh'     => 'nullable|date',
            'cccd'          => 'nullable|string|unique:nguoi_dungs,cccd,' . $user->id,
        ], [
            'ho_ten.required' => 'Họ tên không được để trống.',
            'email.unique'    => 'Email này đã có người sử dụng.',
            'cccd.unique'     => 'Số CCCD này đã có người sử dụng.',
        ]);

        // Lấy lại model Eloquent chính xác để tránh lỗi linter và đảm bảo method update tồn tại
        $me = NguoiDung::find($user->id);
        $me->update([
            'ho_ten'        => $request->ho_ten,
            'email'         => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'ngay_sinh'     => $request->ngay_sinh,
            'cccd'          => $request->cccd,
            'avatar'        => $request->avatar,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'data' => $user
        ]);
    }

    public function doiMatKhau(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Bạn chưa đăng nhập!'], 401);
        }

        $request->validate([
            'password_cu' => 'required',
            'password_moi' => 'required|min:6|different:password_cu',
            're_password_moi' => 'required|same:password_moi',
        ], [
            'password_moi.min' => 'Mật khẩu mới ít nhất 6 ký tự.',
            'password_moi.different' => 'Mật khẩu mới phải khác mật khẩu cũ.',
            're_password_moi.same' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Kiểm tra mật khẩu cũ (Hỗ trợ cả plain text và hash)
        $passwordOldValid = false;
        if ($user->password && strlen($user->password) >= 60) {
            $passwordOldValid = Hash::check($request->password_cu, $user->password);
        } else {
            $passwordOldValid = ($user->password === $request->password_cu);
        }

        if (!$passwordOldValid) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu cũ không chính xác.'
            ], 400);
        }

        // Lấy lại model Eloquent chính xác
        $me = NguoiDung::find($user->id);
        $me->update([
            'password' => Hash::make($request->password_moi)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ]);
    }
}
