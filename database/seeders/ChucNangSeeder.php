<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tắt kiểm tra khóa ngoại để xóa sạch dữ liệu cũ (nếu có)
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('chuc_nangs')->truncate();
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        // 2. Danh sách chức năng (Gán ID cứng để dễ phân quyền sau này)
        $data = [
            [
                'id'            => 1,
                'ten_chuc_nang' => 'Quản lý tài khoản',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 2,
                'ten_chuc_nang' => 'Quản lý tour',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 3,
                'ten_chuc_nang' => 'Quản lý voucher',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 4,
                'ten_chuc_nang' => 'Quản lý phương tiện',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 5,
                'ten_chuc_nang' => 'Quản lý hệ thống', // (Phân quyền, Cấu hình...)
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 6,
                'ten_chuc_nang' => 'Quản lý bình luận', // (Đánh giá)
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 7,
                'ten_chuc_nang' => 'Quản lý bài viết', // (Tin tức, Blog)
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 8,
                'ten_chuc_nang' => 'Quản lý thống kê',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id'            => 9,
                'ten_chuc_nang' => 'Quản lý liên hệ',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        // 3. Insert vào database
        DB::table('chuc_nangs')->insert($data);
    }
}
