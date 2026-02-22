<?php

namespace App\Http\Controllers;

use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhanQuyenController
{

    // 1. CẤP QUYỀN

    public function themPhanQuyen(Request $request)
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
        $request->validate([
            'id_chuc_vu'   => 'required|integer',
            'id_chuc_nang' => 'required|integer',
        ]);

        PhanQuyen::firstOrCreate([
            'id_chuc_vu'   => $request->id_chuc_vu,
            'id_chuc_nang' => $request->id_chuc_nang
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Đã cấp quyền thành công!'
        ]);
    }


    // 2. XÓA QUYỀN
    public function xoaPhanQuyen(Request $request)
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
        PhanQuyen::where('id', $request->id)->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Đã xóa quyền thành công!'
        ]);
    }


    // 3. LẤY QUYỀN ĐÃ CẤP CHO CHỨC VỤ
    public function getChiTietPhanQuyen(Request $request)
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
        $request->validate([
            'id_chuc_vu' => 'required|integer'
        ]);

        $data = PhanQuyen::where('id_chuc_vu', $request->id_chuc_vu)
            ->join('chuc_nangs', 'chuc_nangs.id', '=', 'phan_quyens.id_chuc_nang')
            ->select(
                'phan_quyens.id',
                'phan_quyens.id_chuc_nang',
                'chuc_nangs.ten_chuc_nang'
            )
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
