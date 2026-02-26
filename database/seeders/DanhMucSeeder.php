<?php

namespace Database\Seeders;

use App\Models\DanhMuc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DanhMuc::insert([
            ['ten_danh_muc' => 'Tour Miền Bắc', 'mo_ta' => 'Các tour du lịch khu vực miền Bắc'],
            ['ten_danh_muc' => 'Tour Miền Trung', 'mo_ta' => 'Các tour du lịch khu vực miền Trung'],
            ['ten_danh_muc' => 'Tour Miền Nam', 'mo_ta' => 'Các tour du lịch khu vực miền Nam'],
        ]);
    }
}

