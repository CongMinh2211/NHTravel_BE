<?php

namespace App\Http\Controllers;

use App\Models\LichTrinh;
use App\Models\PhanQuyen;
use App\Models\TourAnh;
use App\Models\TourDuLich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourDuLichController
{
    public function getData()
    {
        return response()->json([
            'status' => true,
            'data' => TourDuLich::select('id', 'ten_tour')->get()
        ]);
    }

    public function themTour(Request $request)
    {

        $id_chuc_nang = 2;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }
        // 1. Kiểm tra token admin
        $user = $request->user(); // Nếu dùng sanctum/passport
        if (!$user || $user->id_chuc_vu != 1) {
            return response()->json(['message' => 'Bạn không thể tạo tour'], 401);
        }

        // 2. Tạo ma_tour tự động tăng (NH001, NH002...)
        $lastTour = TourDuLich::latest('id')->first();
        $ma_tour = 'NH' . str_pad($lastTour?->id + 1 ?? 1, 3, '0', STR_PAD_LEFT);

        // 3. Lưu bản tour_du_lich
        $tour = TourDuLich::create([
            'ma_tour' => $ma_tour,
            'ten_tour' => $request->ten_tour,
            'mo_ta' => $request->mo_ta,
            'id_danh_muc' => $request->id_danh_muc,
            'gia_nguoi_lon' => $request->gia_nguoi_lon,
            'gia_tre_em' => $request->gia_tre_em,
            'ngay_di' => $request->ngay_di,
            'ngay_ve' => $request->ngay_ve,
            'gio_di' => $request->gio_di,
            'gio_ve' => $request->gio_ve,
            'dia_diem' => $request->dia_diem,
            'tao_boi' => $user->id,
            'so_cho' => $request->so_cho,
            'so_cho_con' => $request->so_cho,
            'trang_thai' => $request->trang_thai
        ]);

        // 4. Lưu ảnh tour từ URL
        $anhArr = $request->input('anh', []); // lấy array URL, mặc định rỗng
        if (is_array($anhArr)) {
            foreach ($anhArr as $url) {
                TourAnh::create([
                    'id_tour' => $tour->id,
                    'url' => $url,
                    'mo_ta' => null
                ]);
            }
        }

        // 5. Lưu lịch trình
        $lichTrinhArr = $request->input('lich_trinh', []); // lấy array lich_trinh từ JSON
        if (is_array($lichTrinhArr)) {
            foreach ($lichTrinhArr as $index => $lt) {
                LichTrinh::create([
                    'id_tour' => $tour->id,
                    'tieu_de' => $lt['tieu_de'] ?? '',
                    'noi_dung' => $lt['noi_dung'] ?? '',
                    'ngay_lich_trinh' => $index + 1,
                    'thu_tu' => $index + 1
                ]);
            }
        }

        return response()->json(['message' => 'Thêm tour ' . $request->ten_tour . ' thành công']);
    }

    //lấy danh sách tour
    public function danhSachTour(Request $request)
    {

        $user = $request->user(); // ← Sanctum tự check token

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        $data = TourDuLich::with([
            'danhMuc:id,ten_danh_muc',
            'nguoiDung:id,ho_ten',
            'anh' => function ($q) {
                $q->select('id', 'id_tour', 'url')->limit(1); // Lấy ảnh đầu tiên làm ảnh đại diện
            }
        ])
            ->orderBy('id', 'desc')
            ->get();

        // Format để FE dùng đúng 100%
        $result = $data->map(function ($item) {
            return [
                "id"            => $item->id,
                "ma_tour"       => $item->ma_tour,
                "ten_tour"      => $item->ten_tour,
                "mo_ta"         => $item->mo_ta,
                "danh_muc"      => $item->danhMuc->ten_danh_muc ?? null,
                "nguoi_tao"     => $item->nguoiDung->ho_ten ?? null,
                "gia_nguoi_lon" => $item->gia_nguoi_lon,
                "gia_tre_em"    => $item->gia_tre_em,
                "ngay_di"       => $item->ngay_di,
                "ngay_ve"       => $item->ngay_ve,
                "dia_diem"      => $item->dia_diem,
                "so_cho"        => $item->so_cho,
                "so_cho_con"    => $item->so_cho_con,
                "trang_thai"    => $item->trang_thai,
                //"anh"           => $item->anh->first()->url ?? null,
                "anh" => optional($item->anh->first())->url,
            ];
        });

        return response()->json([
            "status" => 1,
            "message" => "Load dữ liệu thành công!",
            "data" => $result
        ]);
    }

    public function chiTietTour(Request $request, $id)
    {
        $id_chuc_nang = 2;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        $tour = TourDuLich::with([
            'danhMuc:id,ten_danh_muc',
            'nguoiDung:id,ho_ten,email',
            'anh:id,id_tour,url',
            'lichTrinhs:id,id_tour,tieu_de,noi_dung,ngay_lich_trinh'
        ])->find($id);

        if (!$tour) {
            return response()->json([
                "status" => 0,
                "message" => "Không tìm thấy tour!"
            ], 404);
        }

        $data = [
            "id"            => $tour->id,
            "ma_tour"       => $tour->ma_tour,
            "ten_tour"      => $tour->ten_tour,
            "mo_ta"         => $tour->mo_ta,
            "danh_muc"      => $tour->danhMuc->ten_danh_muc ?? null,
            "nguoi_dung" => [
                "ho_ten" => $tour->nguoiDung->ho_ten ?? null,
                "email"  => $tour->nguoiDung->email ?? null,
            ],
            //"nguoi_dung"    => $tour->nguoiDung->ho_ten ?? null,
            "anh"           => $tour->anh,
            "lich_trinh"    => $tour->lichTrinhs,
            "ngay_di"       => $tour->ngay_di,
            "ngay_ve"       => $tour->ngay_ve,
            "gia_nguoi_lon" => $tour->gia_nguoi_lon,
            "gia_tre_em"    => $tour->gia_tre_em,
            "so_cho"        => $tour->so_cho,
            "so_cho_con"    => $tour->so_cho_con,
            "trang_thai"    => $tour->trang_thai,
        ];

        return response()->json([
            "status" => 1,
            "message" => "Lấy chi tiết thành công!",
            "data" => $data
        ]);
    }


    // public function capNhatTour(Request $request, $id)
    // {

    //     $user = $request->user();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 0,
    //             'message' => 'Token không hợp lệ hoặc đã hết hạn!'
    //         ], 401);
    //     }

    //     $tour = TourDuLich::with([
    //         'danhMuc:id,ten_danh_muc',
    //         'nguoiDung:id,ho_ten,email',
    //         'anh:id,id_tour,url',
    //         'lichTrinhs:id,id_tour,tieu_de,noi_dung,ngay_lich_trinh'
    //     ])->find($id);

    //     if (!$tour) {
    //         return response()->json([
    //             "status" => 0,
    //             "message" => "Tour không tồn tại!"
    //         ], 404);
    //     }

    //     $tour->update([
    //         'ma_tour'       => $request->ma_tour,
    //         'ten_tour'      => $request->ten_tour,
    //         'mo_ta'         => $request->mo_ta,
    //         'id_danh_muc'   => $request->id_danh_muc,
    //         'gia_nguoi_lon' => $request->gia_nguoi_lon,
    //         'gia_tre_em'    => $request->gia_tre_em,
    //         'ngay_di'       => $request->ngay_di,
    //         'ngay_ve'       => $request->ngay_ve,
    //         'gio_di'        => $request->gio_di,
    //         'gio_ve'        => $request->gio_ve,
    //         'dia_diem'      => $request->dia_diem,
    //         'so_cho'        => $request->so_cho,
    //         'so_cho_con'    => $request->so_cho_con,
    //         'trang_thai'    => $request->trang_thai,
    //     ]);

    //     return response()->json([
    //         "status" => 1,
    //         "message" => "Cập nhật tour thành công!"
    //     ]);
    // }
    public function capNhatTour(Request $request, $id)
    {
        $id_chuc_nang = 2;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }

        $tour = TourDuLich::find($id);

        if (!$tour) {
            return response()->json([
                "status" => 0,
                "message" => "Tour không tồn tại!"
            ], 404);
        }

        //  CẬP NHẬT DỮ LIỆU TOUR

        $tour->update([
            'ma_tour'       => $request->ma_tour,
            'ten_tour'      => $request->ten_tour,
            'mo_ta'         => $request->mo_ta,
            'id_danh_muc'   => $request->id_danh_muc,
            'gia_nguoi_lon' => $request->gia_nguoi_lon,
            'gia_tre_em'    => $request->gia_tre_em,
            'ngay_di'       => $request->ngay_di,
            'ngay_ve'       => $request->ngay_ve,
            'gio_di'        => $request->gio_di,
            'gio_ve'        => $request->gio_ve,
            'dia_diem'      => $request->dia_diem,
            'so_cho'        => $request->so_cho,
            'so_cho_con'    => $request->so_cho_con,
            'trang_thai'    => $request->trang_thai
        ]);

        return response()->json([
            "status" => 1,
            "message" => "Cập nhật tour thành công!"
        ]);
    }


    public function xoaTour(Request $request, $id)
    {
        $id_chuc_nang = 2;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Token không hợp lệ hoặc đã hết hạn!'
            ], 401);
        }
        $tour = TourDuLich::find($id);

        if (!$tour) {
            return response()->json([
                "status" => 0,
                "message" => "Tour không tồn tại!"
            ], 404);
        }

        // Xoá ảnh liên quan
        $tour->anh()->delete();

        // Xoá lịch trình
        $tour->lichTrinhs()->delete();

        // Xoá đặt tour
        $tour->datTours()->delete();

        // Xoá tour
        $tour->delete();

        return response()->json([
            "status" => 1,
            "message" => "Xoá tour thành công!"
        ]);
    }

    //lấy danh sách tour bên KHÁCH HÀNG
    public function getlistCustomer(Request $request)
    {
        $data = TourDuLich::with([
            'danhMuc:id,ten_danh_muc',
            'nguoiDung:id,ho_ten',
            'phuongTiens:id,ten_phuong_tien',
            'anh' => function ($q) {
                $q->select('id', 'id_tour', 'url')->limit(1); // Lấy ảnh đầu tiên làm ảnh đại diện
            }
        ])
            ->orderBy('id', 'desc')
            ->get();

        $result = $data->map(function ($item) {
            return [
                "id"            => $item->id,
                "ma_tour"       => $item->ma_tour,
                "ten_tour"      => $item->ten_tour,
                "mo_ta"         => $item->mo_ta,
                "id_danh_muc"   => $item->id_danh_muc,
                "danh_muc"      => $item->danhMuc->ten_danh_muc ?? null,
                "nguoi_tao"     => $item->nguoiDung->ho_ten ?? null,
                "gia_nguoi_lon" => $item->gia_nguoi_lon,
                "gia_tre_em"    => $item->gia_tre_em,
                "ngay_di"       => $item->ngay_di,
                "ngay_ve"       => $item->ngay_ve,
                "dia_diem"      => $item->dia_diem,
                "so_cho"        => $item->so_cho,
                "so_cho_con"    => $item->so_cho_con,
                "trang_thai"    => $item->trang_thai,
                //"anh"           => $item->anh->first()->url ?? null,
                "anh" => optional($item->anh->first())->url,
                "phuong_tien" => $item->phuongTiens->pluck('ten_phuong_tien')->toArray(),
            ];
        });

        return response()->json([
            "status" => 1,
            "message" => "Load dữ liệu thành công!",
            "data" => $result
        ]);
    }
}
