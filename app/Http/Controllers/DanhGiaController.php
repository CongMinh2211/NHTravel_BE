<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DanhGiaController
{
    public function getData()
    {
        $data = DanhGia::join('nguoi_dungs', 'nguoi_dungs.id', '=', 'danh_gias.id_nguoi_dung')
            ->join('tour_du_liches', 'tour_du_liches.id', '=', 'danh_gias.id_tour')
            ->select(
                'danh_gias.*',
                'nguoi_dungs.ho_ten',
                'nguoi_dungs.email',
                'danh_gias.phan_hoi',
                'tour_du_liches.ten_tour'
            )
            ->orderBy('danh_gias.id', 'DESC')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function changeStatus(Request $request)
    {
        $id_chuc_nang = 6;
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
        $danhGia = DanhGia::find($request->id);

        if (!$danhGia) {
            return response()->json([
                'status' => 0,
                'message' => 'Bình luận không tồn tại!'
            ]);
        }

        $danhGia->trang_thai = $request->trang_thai;
        $danhGia->save();

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }
    public function destroy(Request $request)
    {
        $id_chuc_nang = 6;
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

        DanhGia::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa bình luận thành công',
        ]);
    }
    public function search(Request $request)
    {
        $keyword = '%' . $request->keyword . '%';

        $data = DanhGia::join('nguoi_dungs', 'nguoi_dungs.id', '=', 'danh_gias.id_nguoi_dung')
            ->join('tour_du_liches', 'tour_du_liches.id', '=', 'danh_gias.id_tour')
            ->where(function ($query) use ($keyword) {
                $query->where('nguoi_dungs.ho_ten', 'like', $keyword)
                    ->orWhere('danh_gias.binh_luan', 'like', $keyword)
                    ->orWhere('tour_du_liches.ten_tour', 'like', $keyword);
            })
            ->select(
                'danh_gias.*',
                'nguoi_dungs.ho_ten',
                'tour_du_liches.ten_tour'
            )
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }




    public function getDataCustomerBinhLuan($id)
    {
        $data = DanhGia::where('id_tour', $id)
            ->join('nguoi_dungs', 'nguoi_dungs.id', 'danh_gias.id_nguoi_dung')
            ->where('danh_gias.trang_thai', 'hien_thi')
            ->select('danh_gias.*', 'nguoi_dungs.ho_ten', 'nguoi_dungs.avatar')
            ->get()
            ->map(function ($item) {
                // Nếu hinh_anh là string và có thể decode
                if (is_string($item->hinh_anh)) {
                    $decoded = json_decode($item->hinh_anh, true);
                    $item->hinh_anh = is_array($decoded) ? $decoded : [];
                }
                return $item;
            });



        return response()->json([
            'data' => $data
        ]);
    }


    public function binhLuantour(Request $request)
    {
        $id_chuc_nang = 6;
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
        // Lấy user đúng cách
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Bạn chưa đăng nhập!'
            ], 401);
        }

        // Tạo trước bình luận
        $danhGia = DanhGia::create([
            'id_nguoi_dung' => $user->id,
            'id_tour'       => $request->id_tour,
            'binh_luan'     => $request->binh_luan,   // FE gửi binh_luan
            'diem'          => $request->diem,
            'trang_thai'    => 'cho_duyet',
        ]);

        // Xử lý ảnh upload
        if ($request->hasFile('hinh_anh')) {

            $arr = [];

            foreach ($request->file('hinh_anh') as $img) {

                $name = time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('uploads/binhluan'), $name);

                // URL sạch, không escape
                $arr[] = asset('uploads/binhluan/' . $name);
            }

            $danhGia->hinh_anh = json_encode($arr, JSON_UNESCAPED_SLASHES);
            $danhGia->save();
        }



        return response()->json([
            'status' => 1,
            'message' => 'Bạn đã gửi đánh giá thành công!'
        ]);
    }
    public function phanHoi(Request $request)
    {
        $id_chuc_nang = 6;
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
        $danhGia = DanhGia::find($request->id);

        if (!$danhGia) {
            return response()->json([
                'status' => 0,
                'message' => 'Bình luận không tồn tại!'
            ]);
        }

        $danhGia->phan_hoi = $request->phan_hoi;


        $danhGia->save();

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật phản hồi thành công!'
        ]);
    }

    public function getDiemTrungBinh($id_tour)
    {
        $danh_gia = DanhGia::where('id_tour', $id_tour)
            ->where('trang_thai', 'hien_thi') // Chỉ lấy đánh giá đã duyệt
            ->selectRaw('AVG(diem) as diem_tb, COUNT(*) as so_luong')
            ->first();

        return response()->json([
            'status'    => true,
            'diem_tb'   => round($danh_gia->diem_tb, 1), // Làm tròn 1 chữ số thập phân
            'so_luong'  => $danh_gia->so_luong,
        ]);
    }
}
