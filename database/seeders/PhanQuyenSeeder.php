<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhanQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Làm sạch bảng trước khi seed
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = OFF;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('phan_quyens')->truncate();
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = ON;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        $now = now();

        $data = [
            // 1. ADMIN (ID: 1) - QUYỀN LỰC TUYỆT ĐỐI (Full 1 -> 9)
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 1, 'created_at' => $now, 'updated_at' => $now], // QL Tài khoản
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 2, 'created_at' => $now, 'updated_at' => $now], // QL Tour
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 3, 'created_at' => $now, 'updated_at' => $now], // QL Voucher
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 4, 'created_at' => $now, 'updated_at' => $now], // QL Phương tiện
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 5, 'created_at' => $now, 'updated_at' => $now], // QL Hệ thống
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 6, 'created_at' => $now, 'updated_at' => $now], // QL Bình luận
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 7, 'created_at' => $now, 'updated_at' => $now], // QL Bài viết
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 8, 'created_at' => $now, 'updated_at' => $now], // QL Thống kê
            ['id_chuc_vu' => 1, 'id_chuc_nang' => 9, 'created_at' => $now, 'updated_at' => $now], // QL Liên hệ

            // 2. NHÂN VIÊN SALE (ID: 2) - Bán hàng & CSKH
            ['id_chuc_vu' => 2, 'id_chuc_nang' => 2, 'created_at' => $now, 'updated_at' => $now], // QL Tour (Để tư vấn)
            ['id_chuc_vu' => 2, 'id_chuc_nang' => 3, 'created_at' => $now, 'updated_at' => $now], // QL Voucher (Tặng mã cho khách)
            ['id_chuc_vu' => 2, 'id_chuc_nang' => 6, 'created_at' => $now, 'updated_at' => $now], // QL Bình luận (Trả lời review)
            ['id_chuc_vu' => 2, 'id_chuc_nang' => 7, 'created_at' => $now, 'updated_at' => $now], // QL Bài viết (Đăng tin khuyến mãi)
            ['id_chuc_vu' => 2, 'id_chuc_nang' => 9, 'created_at' => $now, 'updated_at' => $now], // QL Liên hệ (Check tin nhắn)

            // 3. NHÂN VIÊN KỸ THUẬT (ID: 3) - Bảo trì hệ thống
            ['id_chuc_vu' => 3, 'id_chuc_nang' => 1, 'created_at' => $now, 'updated_at' => $now], // QL Tài khoản (Hỗ trợ reset pass...)
            ['id_chuc_vu' => 3, 'id_chuc_nang' => 5, 'created_at' => $now, 'updated_at' => $now], // QL Hệ thống (Cấu hình, fix lỗi)

            // 4. QUẢN LÝ PHƯƠNG TIỆN (ID: 4) - Điều phối xe
            ['id_chuc_vu' => 4, 'id_chuc_nang' => 4, 'created_at' => $now, 'updated_at' => $now], // QL Phương tiện (Duy nhất)
        ];

        // 3. Chèn dữ liệu vào bảng
        DB::table('phan_quyens')->insert($data);
    }
}

