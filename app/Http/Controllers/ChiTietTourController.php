<?php

namespace App\Http\Controllers;

use App\Models\LichKhoiHanh;
use App\Models\LichTrinh;
use App\Models\TourDuLich;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChiTietTourController extends Controller
{
    public function getDataTour(Request $request)
    {
        $data_tour = TourDuLich::with(['anh', 'phuongTiens'])->where('id', $request->id)->first();

        // $suat_chieu = SuatChieu::where('id_phim', $request->id)
        //     ->where('tinh_trang', 1) // nếu cần lọc chỉ suất chiếu đang hoạt động
        //     ->get();

        $lich_trinh = LichTrinh::where('id_tour', $request->id)
            ->get();

        // $list_phim_khac = Phim::where('id', '!=', $request->id)->get();

        if ($data_tour) {
            return response()->json([
                'status'            => true,
                'data_tour'         => $data_tour,
                'data_lich_trinh'         => $lich_trinh,
                // 'data_suat_chieu'   => $suat_chieu,
                // 'list_phim_khac'     => $list_phim_khac
            ]);
        }
        return response()->json([
            'status'     =>  false,
            'message'    =>  "Không tồn tại tour này!!!"
        ]);
    }
}
