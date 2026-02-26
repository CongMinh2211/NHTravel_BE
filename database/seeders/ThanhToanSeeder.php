<?php

namespace Database\Seeders;

use App\Models\ThanhToan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ThanhToanSeeder extends Seeder
{
    public function run()
    {
        $phuongThucList = ['momo', 'vnpay', 'bank', 'tien_mat', 'visa', 'mbbank'];

        // Lấy toàn bộ đơn tour hợp lệ kèm giá
        $datTours = DB::table('dat_tours')->select('id', 'tien_thuc_nhan')->get();

        if ($datTours->isEmpty()) {
            return; // không có đơn thì không seed
        }

        $data = [];

        foreach ($datTours as $datTour) {

            // Mỗi đơn sẽ có 1 hoặc 0 thanh toán
            $hasPayment = rand(0, 1);

            if (!$hasPayment) continue;

            $trangThai = rand(0, 1) ? 'thanh_cong' : 'that_bai';

            $data[] = [
                'id_dat_tour' => $datTour->id,
                'phuong_thuc' => $phuongThucList[array_rand($phuongThucList)],
                'thoi_gian_thanh_toan' => Carbon::now()->subDays(rand(1, 60)),
                'so_tien' => $datTour->tien_thuc_nhan,
                'trang_thai' => $trangThai,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ThanhToan::insert($data);
    }
}

