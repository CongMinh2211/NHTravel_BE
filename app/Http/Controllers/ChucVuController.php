<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ChucVuController extends Controller
{
    public function getData()
    {
        $data = ChucVu::all();
        return response()->json([
            'data' => $data
        ]);
    }

    public function addData(Request $request)
    {
        // QUYỀN QUẢN LÝ HỆ THỐNG = id_chuc_nang 5
        $id_chuc_nang = 5;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check && $id_chuc_vu != 1) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }

        ChucVu::create([
            'ten_chuc_vu'   => $request->ten_chuc_vu,
            'slug_chuc_vu'  => $request->slug_chuc_vu,
            'tinh_trang'    => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm chức vụ thành công',
        ]);
    }

    public function update(Request $request)
    {
        $id_chuc_nang = 5;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check && $id_chuc_vu != 1) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }

        ChucVu::where('id', $request->id)->update([
            'ten_chuc_vu'   => $request->ten_chuc_vu,
            'slug_chuc_vu'  => $request->slug_chuc_vu,
            'tinh_trang'    => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật chức vụ thành công',
        ]);
    }

    public function destroy(Request $request)
    {
        $id_chuc_nang = 5;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check && $id_chuc_vu != 1) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }

        ChucVu::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa chức vụ thành công',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $id_chuc_nang = 5;
        $id_chuc_vu   = Auth::guard('sanctum')->user()->id_chuc_vu;

        $check = PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
                          ->where('id_chuc_nang', $id_chuc_nang)
                          ->first();

        if (!$check && $id_chuc_vu != 1) {
            return response()->json([
                'status'    =>  0,
                'message'   =>  'Bạn không có quyền thực hiện chức năng này!'
            ]);
        }

        $chucVu = ChucVu::where('id', $request->id)->first();
        $chucVu->tinh_trang = !$chucVu->tinh_trang;
        $chucVu->save();

        return response()->json([
            'status' => true,
            'message' => 'Thay đổi trạng thái thành công',
        ]);
    }

    public function search(Request $request)
    {
        $noi_dung = '%' . $request->noi_dung . '%';

        $data = ChucVu::where('ten_chuc_vu', 'like', $noi_dung)
            ->orWhere('slug_chuc_vu', 'like', $noi_dung)
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
