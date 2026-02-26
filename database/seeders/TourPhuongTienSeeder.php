<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\TourPhuongTien;
use Illuminate\Database\Seeder;

class TourPhuongTienSeeder extends Seeder
{
    public function run()
    {
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = OFF;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('tour_phuong_tiens')->truncate();
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = ON;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        // Giả sử:
        // Tour 1 (Đà Nẵng): Dùng 1 xe 7 chỗ (ID 1) và 1 xe Giường nằm (ID 2)
        // Tour 2 (Sapa): Dùng 1 xe Limousine (ID 3)
        // Tour 3 (Nha Trang): Dùng lại xe 7 chỗ (ID 1) - (Xe 1 chạy xong tour 1 rồi chạy tour 3)

        TourPhuongTien::insert([
            [
                'id_tour' => 1,
                'id_phuong_tien' => 1, // Xe 43A-123.45
                'ghi_chu' => 'Xe dẫn đoàn, chở hướng dẫn viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tour' => 2,
                'id_phuong_tien' => 2, // Xe 43B-567.89
                'ghi_chu' => 'Xe chở khách chính',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tour' => 3,
                'id_phuong_tien' => 3, // Xe Limousine
                'ghi_chu' => 'Phục vụ khách VIP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tour' => 4, // Tour 2 dùng thêm 1 xe 16 chỗ
                'id_phuong_tien' => 4, // Xe 16 chỗ
                'ghi_chu' => 'Xe chở hành lý và staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Ví dụ về việc tái sử dụng xe cho tour khác (khác thời gian)
            [
                'id_tour' => 5, // Giả sử có tour ID 1
                'id_phuong_tien' => 5, // Xe 43A-123.45 quay lại phục vụ tour này
                'ghi_chu' => 'Xe đón tiễn sân bay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tour 6
            [
                'id_tour' => 6,
                'id_phuong_tien' => 2,
                'ghi_chu' => 'Xe chở khách thường',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tour 7
            [
                'id_tour' => 7,
                'id_phuong_tien' => 3,
                'ghi_chu' => 'Xe du lịch phổ thông',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tour 8
            [
                'id_tour' => 8,
                'id_phuong_tien' => 1,
                'ghi_chu' => 'Xe phụ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tour 9
            [
                'id_tour' => 9,
                'id_phuong_tien' => 6,
                'ghi_chu' => 'Xe máy lạnh 45 chỗ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tour 10
            [
                'id_tour' => 10,
                'id_phuong_tien' => 5,
                'ghi_chu' => 'Xe VIP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tour 11
            [
                'id_tour' => 11,
                'id_phuong_tien' => 7,
                'ghi_chu' => 'Xe chất lượng cao',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tour 12
            [
                'id_tour' => 12,
                'id_phuong_tien' => 4,
                'ghi_chu' => 'Xe trung chuyển',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


