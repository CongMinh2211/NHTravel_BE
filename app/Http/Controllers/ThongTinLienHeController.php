<?php

namespace App\Http\Controllers;

use App\Models\ThongTinLienHe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ThongTinLienHeController extends Controller
{
    public function guiThongTin(Request $request)
    {
        ThongTinLienHe::create([
            'id_khach_hang' => null,
            'ten'  => $request->ten,
            'email'  => $request->email,
            'so_dien_thoai'  => $request->so_dien_thoai,
            'tin_nhan'  => $request->tin_nhan,
            'trang_thai'  => $request->trang_thai,
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Thông tin của bạn đã được gửi thành công!',
        ]);
    }

    public function getData()
    {
        $data = ThongTinLienHe::leftJoin('nguoi_dungs', 'nguoi_dungs.id', '=', 'thong_tin_lien_hes.id_khach_hang')
            ->select(
                'thong_tin_lien_hes.*',
                'nguoi_dungs.ho_ten',
                'nguoi_dungs.email as email_khach_hang'
            )
            ->orderBy('thong_tin_lien_hes.id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }
    public function destroy(Request $request)
    {
        $id = $request->id;


        $lienHe = ThongTinLienHe::find($id);



        $lienHe->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa liên hệ thành công.',
        ]);
    }
    public function changeStatus(Request $request)
    {
        $lh = ThongTinLienHe::find($request->id);

        $lh->trang_thai = $request->trang_thai;
        $lh->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }
}
