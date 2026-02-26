<?php

namespace Database\Seeders;

use App\Models\MaGiamGia;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MaGiamGiaSeeder extends Seeder
{
    public function run(): void
    {
        MaGiamGia::insert([
            [
                'ma' => 'DISCOUNT10',
                'mo_ta' => 'Giảm 10% cho đơn hàng đầu tiên',
                'phan_tram_giam' => 10,
                'hieu_luc_tu' => Carbon::now()->toDateString(),
                'hieu_luc_den' => Carbon::now()->addDays(30)->toDateString(),
                'so_luong' => 100,
                'tao_boi' => 1,
                'trang_thai' => 'con_hieu_luc',
            ],
            [
                'ma' => 'DISCOUNT20',
                'mo_ta' => 'Giảm 20% cho khách hàng VIP',
                'phan_tram_giam' => 20,
                'hieu_luc_tu' => Carbon::now()->toDateString(),
                'hieu_luc_den' => Carbon::now()->addDays(60)->toDateString(),
                'so_luong' => 50,
                'tao_boi' => 1,
                'trang_thai' => 'con_hieu_luc',
            ],
            [
                'ma' => 'NEWYEAR25',
                'mo_ta' => 'Ưu đãi đầu năm mới - Giảm 25%',
                'phan_tram_giam' => 25,
                'hieu_luc_tu' => Carbon::now()->addDays(-5)->toDateString(),
                'hieu_luc_den' => Carbon::now()->addDays(15)->toDateString(),
                'so_luong' => 30,
                'tao_boi' => 1,
                'trang_thai' => 'con_hieu_luc',
            ],
            [
                'ma' => 'SUMMER15',
                'mo_ta' => 'Khuyến mãi mùa hè - Giảm 15%',
                'phan_tram_giam' => 15,
                'hieu_luc_tu' => Carbon::now()->addDays(-40)->toDateString(),
                'hieu_luc_den' => Carbon::now()->addDays(-10)->toDateString(),
                'so_luong' => 0,
                'tao_boi' => 1,
                'trang_thai' => 'het_hieu_luc',
            ],
            [
                'ma' => 'FLASH5',
                'mo_ta' => 'Flash Sale - Giảm 5% trong hôm nay',
                'phan_tram_giam' => 5,
                'hieu_luc_tu' => Carbon::now()->toDateString(),
                'hieu_luc_den' => Carbon::now()->toDateString(),
                'so_luong' => 10,
                'tao_boi' => 1,
                'trang_thai' => 'con_hieu_luc',
            ],
            [
                'ma' => 'BLACKFRIDAY30',
                'mo_ta' => 'Black Friday - Giảm 30%',
                'phan_tram_giam' => 30,
                'hieu_luc_tu' => Carbon::now()->addDays(-20)->toDateString(),
                'hieu_luc_den' => Carbon::now()->addDays(10)->toDateString(),
                'so_luong' => 25,
                'tao_boi' => 1,
                'trang_thai' => 'con_hieu_luc',
            ],
        ]);
    }
}

