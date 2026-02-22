<?php

namespace App\Http\Controllers;

use App\Models\PhanQuyen;
use App\Models\PhuongTien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PhuongTienController extends Controller
{

    public function getData()
    {
        $data = PhuongTien::all();
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $data
        ]);
    }


    public function addData(Request $request)
    {
        $id_chuc_nang = 4;
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
        $pt = PhuongTien::create([
            'ten_phuong_tien' => $request->ten_phuong_tien,
            'mo_ta' => $request->mo_ta,
            'bien_so' => $request->bien_so,
            'suc_chua' => $request->suc_chua,
            'trang_thai' => $request->trang_thai,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm phương tiện thành công',
            'data' => $pt  // TRẢ VỀ PHƯƠNG TIỆN VỪA TẠO
        ]);
    }



    public function upDate(Request $request)
    {
        $id_chuc_nang = 4;
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
        PhuongTien::where('id', $request->id)->update([
            'ten_phuong_tien' => $request->ten_phuong_tien,
            'mo_ta' => $request->mo_ta,
            'bien_so' => $request->bien_so,
            'suc_chua' => $request->suc_chua,
            'trang_thai' => $request->trang_thai,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật phương tiện thành công',
        ]);
    }


    public function destroy(Request $request)
    {
        $id_chuc_nang = 4;
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
        $pt = PhuongTien::find($request->id);

        if (!$pt) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy phương tiện'
            ]);
        }

        $pt->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa phương tiện thành công'
        ]);
    }


    public function changeStatus(Request $request)
    {
        $id_chuc_nang = 4;
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
        $phuongtien = PhuongTien::find($request->id);

        $phuongtien->trang_thai = ($phuongtien->trang_thai + 1) % 3;

        $phuongtien->save();

        return response()->json([
            'status' => true,
            'message' => 'Thay đổi trạng thái thành công!',
        ]);
    }
}
