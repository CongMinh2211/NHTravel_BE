<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhMucController
{
    public function getData()
    {
        $data = DanhMuc::all();
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $data
        ]);
    }


    public function addData(Request $request)
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
        $data = DanhMuc::create([
            'ten_danh_muc'     => $request->ten_danh_muc,
            'mo_ta'    => $request->mo_ta,
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Thêm danh mục tour ' . $request->ten_danh_muc . ' thành công',
            'data'      => $data
        ]);
    }
    public function update(Request $request)
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
        DanhMuc::where('id', $request->id)->update([
            'ten_danh_muc'     => $request->ten_danh_muc,
            'mo_ta'    => $request->mo_ta,

        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Cập nhật danh mục tour ' . $request->ten_danh_muc . ' thành công',
        ]);
    }

    public function destroy(Request $request)
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
        DanhMuc::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa danh mục tour ' . $request->ten_danh_muc . ' thành công',
        ]);
    }


    public function search(Request $request)
    {
        $keyword  = '%' . $request->ten_danh_muc . '%';

        $data = DanhMuc::where('ten_danh_muc', 'like', $keyword)->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
