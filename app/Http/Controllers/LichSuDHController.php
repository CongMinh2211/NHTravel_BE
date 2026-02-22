<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\DatTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LichSuDHController
{
    public function getData()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập!',
            ]);
        }

        $ds = DatTour::where('id_khach_hang', $user->id)
            ->with([
                'tour:id,ma_tour,ten_tour,ngay_di,ngay_ve',
                'tour.anh:id,id_tour,url',
                'phuongTien:id,ten_phuong_tien',
                'voucher:id,ma,phan_tram_giam'
            ])
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $ds
        ]);
    }
}
