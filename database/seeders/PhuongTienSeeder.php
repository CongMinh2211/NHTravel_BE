<?php

namespace Database\Seeders;

use App\Models\PhuongTien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhuongTienSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = OFF;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('phuong_tiens')->truncate();
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = ON;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        PhuongTien::insert([
            [
                'ten_phuong_tien' => 'Xe 7 chỗ (Innova)',
                'mo_ta' => 'Xe đời mới, máy lạnh tốt',
                'bien_so' => '43A-123.45',
                'suc_chua' => 7,
                'trang_thai' => 1, // Sẵn sàng
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_phuong_tien' => 'Xe giường nằm (Thaco)',
                'mo_ta' => 'Xe 2 tầng, có chăn gối',
                'bien_so' => '43B-567.89',
                'suc_chua' => 40,
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_phuong_tien' => 'Limousine VIP',
                'mo_ta' => 'Ghế massage, wifi 4G',
                'bien_so' => '43A-999.99',
                'suc_chua' => 9,
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_phuong_tien' => 'Ford Transit 16 chỗ',
                'mo_ta' => 'Phục vụ đoàn nhỏ',
                'bien_so' => '43C-111.11',
                'suc_chua' => 16,
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_phuong_tien' => 'Xe điện nội bộ',
                'mo_ta' => 'Di chuyển trong resort',
                'bien_so' => '43D-222.22',
                'suc_chua' => 4,
                'trang_thai' => 2, // Đang bảo trì
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_phuong_tien' => 'Xe 45 chỗ cao cấp',
                'mo_ta' => 'Có máy lạnh, ghế bật ngả, tủ lạnh mini',
                'bien_so' => '43E-333.33',
                'suc_chua' => 45,
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_phuong_tien' => 'Xe du lịch phổ thông',
                'mo_ta' => 'Phục vụ tour đông người, chi phí thấp',
                'bien_so' => '43F-444.44',
                'suc_chua' => 35,
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


