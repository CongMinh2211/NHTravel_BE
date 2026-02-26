<?php

namespace Database\Seeders;

use App\Models\DatTour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatTourSeeder extends Seeder
{
    public function run()
    {
        // Xóa dữ liệu cũ trước khi seed để tránh lỗi UNIQUE constraint
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        }

        DB::table('dat_tours')->truncate();

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        }

        $donHangs = [];
        $ma = 1;
        $now = Carbon::now();

        // Lấy danh sách giá tour thực tế từ CSDL
        $tours = DB::table('tour_du_liches')
            ->select('id', 'gia_nguoi_lon', 'gia_tre_em')
            ->get()
            ->keyBy('id');

        $tourIds = $tours->keys()->toArray();

        // 4 người dùng (id: 1 → 4), tour lấy từ CSDL
        for ($i = 1; $i <= 30; $i++) {
            $id_khach_hang = rand(1, 4);
            $id_tour = $tourIds[array_rand($tourIds)];
            $so_nguoi_lon = rand(1, 5);
            $so_tre_em = rand(0, 3);

            // Lấy giá thực tế từ tour
            $gia_nguoi_lon = $tours[$id_tour]->gia_nguoi_lon;
            $gia_tre_em = $tours[$id_tour]->gia_tre_em;
            $tong_tien = ($so_nguoi_lon * $gia_nguoi_lon) + ($so_tre_em * $gia_tre_em);

            $co_giam_gia = rand(0, 1);
            $giam_gia = $co_giam_gia ? rand(100, 500) : 0;
            $tien_thuc_nhan = max($tong_tien - $giam_gia, 0);

            $donHangs[] = [
                'id_khach_hang'   => $id_khach_hang,
                'id_tour'         => $id_tour,
                'ngay_dat'        => $now->copy()->addDays($i),

                'so_nguoi_lon'    => $so_nguoi_lon,
                'so_tre_em'       => $so_tre_em,
                'tong_tien'       => $tong_tien,
                'giam_gia'        => $giam_gia,
                'tien_thuc_nhan'  => $tien_thuc_nhan,

                'id_ma_giam_gia'  => $co_giam_gia ? rand(1, 3) : null,
                'trang_thai'      => collect(['cho_xu_ly', 'da_thanh_toan', 'da_huy'])->random(),

                'ten_lien_lac'            => 'Khách hàng ' . $id_khach_hang,
                'email_lien_lac'          => 'khach' . $id_khach_hang . '@gmail.com',
                'so_dien_thoai_lien_lac'  => '09' . rand(10000000, 99999999),
                'dia_chi_lien_lac'        => 'Địa chỉ demo',

                'ma_don_hang'     => 'DT' . str_pad($ma++, 6, '0', STR_PAD_LEFT),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        DatTour::insert($donHangs);
    }
}

