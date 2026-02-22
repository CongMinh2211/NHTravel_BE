<?php

namespace App\Http\Controllers;

use App\Models\TourPhuongTien;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TourPhuongTienController extends Controller
{
    public function getData()
    {
        // Join thêm bảng tour để lấy ngày đi, ngày về hiển thị ra FE
        $data = TourPhuongTien::with('tour')->get(); 
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $data
        ]);
    }

    public function getByPhuongTien($id)
    {
        $data = TourPhuongTien::where('id_phuong_tien', $id)
            ->with('tour') // Quan trọng: Phải with('tour') để FE lấy ngày tháng
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function addData(Request $request)
    {
        // 1. Kiểm tra xem xe này đã có trong tour này chưa (tránh trùng lặp)
        $check = TourPhuongTien::where('id_tour', $request->id_tour)
                               ->where('id_phuong_tien', $request->id_phuong_tien)
                               ->first();
        
        if($check) {
            return response()->json([
                'status' => false,
                'message' => 'Xe này đã được thêm vào tour này rồi!',
            ]);
        }

        // 2. Chỉ insert các trường còn lại
        TourPhuongTien::create([
            'id_tour' => $request->id_tour,
            'id_phuong_tien' => $request->id_phuong_tien,
            'ghi_chu' => $request->ghi_chu,
            // ĐÃ BỎ: so_luong, ngay_bat_dau, ngay_ket_thuc
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Phân công xe vào tour thành công',
        ]);
    }

    public function upDate(Request $request)
    {
        // Chỉ update ghi chú hoặc đổi tour/xe
        TourPhuongTien::where('id', $request->id)->update([
            'id_tour' => $request->id_tour,
            'id_phuong_tien' => $request->id_phuong_tien,
            'ghi_chu' => $request->ghi_chu,
            // ĐÃ BỎ: so_luong, ngay_bat_dau, ngay_ket_thuc
        ]);
        
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật phân công xe thành công',
        ]);
    }

    public function destroy(Request $request) 
    {
        TourPhuongTien::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa phân công xe thành công',
        ]);
    }
}