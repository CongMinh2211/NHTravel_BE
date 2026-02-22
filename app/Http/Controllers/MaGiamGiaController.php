<?php

namespace App\Http\Controllers;

use App\Models\MaGiamGia;
use App\Models\PhanQuyen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaGiamGiaController
{
    /**
     * Display a listing of the resource.
     */
    public function getData()
    {
        $data = MaGiamGia::all();
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $data
        ]);
    }
    public function addData(Request $request)
    {
        $id_chuc_nang = 3;
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
        $mg = MaGiamGia::create([
            'ma'  => $request->ma,
            'mo_ta' => $request->mo_ta,
            'phan_tram_giam' => $request->phan_tram_giam,
            'so_luong' => $request->so_luong,
            'hieu_luc_tu' => $request->hieu_luc_tu,
            'hieu_luc_den' => $request->hieu_luc_den,
            'tao_boi' => $request->tao_boi,
            'trang_thai' => $request->trang_thai,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm mã giảm giá thành công',

        ]);
    }
    public function update(Request $request)
    {
        $id_chuc_nang = 3;
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
        MaGiamGia::where('id', $request->id)->update([
            'ma' => $request->ma,
            'mo_ta' => $request->mo_ta,
            'phan_tram_giam' => $request->phan_tram_giam,
            'so_luong' => $request->so_luong,
            'hieu_luc_tu' => $request->hieu_luc_tu,
            'hieu_luc_den' => $request->hieu_luc_den,
            'tao_boi' => $request->tao_boi,
            'trang_thai' => $request->trang_thai,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật mã giảm giá thành công',
        ]);
    }
    public function destroy(Request $request)
    {
        $id_chuc_nang = 3;
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

        MaGiamGia::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa mã giảm giá thành công',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $id_chuc_nang = 3;
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

        $ma = MaGiamGia::find($request->id);

        if (!$ma) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy mã giảm giá'
            ]);
        }

        $ma->trang_thai = $ma->trang_thai === 'con_hieu_luc'
            ? 'het_hieu_luc'
            : 'con_hieu_luc';

        $ma->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật trạng thái mã giảm giá thành công',
            'trang_thai_moi' => $ma->trang_thai
        ]);
    }

    public function findmaGiamGia(Request $request)
    {
        $id_chuc_nang = 3;
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
        $now = Carbon::now();
        $data = MaGiamGia::where('ma', $request->ma)
            ->where('trang_thai', 1)
            ->where('so_luong', '>', 0)
            ->whereDate('hieu_luc_tu', '<=', $now)
            ->whereDate('hieu_luc_den', '>=', $now)
            ->first();
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Áp dụng mã giảm giá thành công',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn',
            ]);
        }
    }

    //Bên khách hàng
    public function getVoucher()
    {
        $data = MaGiamGia::where('trang_thai', 'con_hieu_luc')
            ->where('so_luong', '>', 0)
            ->get();

        return response()->json([
            'status' => true,
            'voucher' => $data
        ]);
    }
}
