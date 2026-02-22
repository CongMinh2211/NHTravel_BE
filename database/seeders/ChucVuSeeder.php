<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Làm sạch bảng cũ
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('chuc_vus')->truncate();
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        $data = [
            [
                'id'            => 1,
                'ten_chuc_vu'   => 'Admin',
                'slug_chuc_vu'  => 'admin',
                'mo_ta'         => 'Quản trị viên cao cấp',
                'tinh_trang'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 2,
                'ten_chuc_vu'   => 'Nhân viên Sale',
                'slug_chuc_vu'  => 'nhan-vien-sale',
                'mo_ta'         => 'Nhân viên tư vấn và bán tour',
                'tinh_trang'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 3,
                'ten_chuc_vu'   => 'Nhân viên Kỹ thuật',
                'slug_chuc_vu'  => 'nhan-vien-ky-thuat',
                'mo_ta'         => 'Bảo trì và sửa lỗi hệ thống',
                'tinh_trang'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 4,
                'ten_chuc_vu'   => 'Quản lý Phương tiện',
                'slug_chuc_vu'  => 'quan-ly-phuong-tien',
                'mo_ta'         => 'Điều phối xe và tài xế',
                'tinh_trang'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 5,
                'ten_chuc_vu'   => 'Khách hàng',
                'slug_chuc_vu'  => 'khach-hang',
                'mo_ta'         => 'Người dùng đặt tour trên hệ thống',
                'tinh_trang'    => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        // 3. Insert vào database
        DB::table('chuc_vus')->insert($data);
    }
}
