<?php

namespace Database\Seeders;

use App\Models\NguoiDung;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NguoiDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NguoiDung::insert([
            [
                'ho_ten' => 'admin',
                'password' => '123456',
                'email' => 'admin@gmail.com',
                'so_dien_thoai' => '0123456786',
                'ngay_sinh' => '1998-06-06',
                'cccd' => '123456789006',
                'id_chuc_vu' => 1,
                'trang_thai' => 'active',
                'avatar' => 'https://ik.imagekit.io/tvlk/blog/2022/02/dia-diem-du-lich-viet-nam-cover.jpeg',
                'hash_reset' => null,
                'hash_active' => null,
            ],
            [
                'ho_ten' => 'Customer Five',
                'password' => '123456',
                'email' => 'customer5@test.com',
                'so_dien_thoai' => '0123456787',
                'ngay_sinh' => '1999-07-07',
                'cccd' => '123456789007',
                'id_chuc_vu' => 3,
                'trang_thai' => 'active',
                'avatar' => 'https://ik.imagekit.io/tvlk/blog/2022/02/dia-diem-du-lich-viet-nam-cover.jpeg',
                'hash_reset' => null,
                'hash_active' => null,
            ],
            [
                'ho_ten' => 'Customer Six',
                'password' => '123456',
                'email' => 'customer6@test.com',
                'so_dien_thoai' => '0123456788',
                'ngay_sinh' => '2000-08-08',
                'cccd' => '123456789008',
                'id_chuc_vu' => 3,
                'trang_thai' => 'active',
                'avatar' => 'https://ik.imagekit.io/tvlk/blog/2022/02/dia-diem-du-lich-viet-nam-cover.jpeg',
                'hash_reset' => null,
                'hash_active' => null,
            ],
            [
                'ho_ten' => 'HEHE',
                'password' => '123456',
                'email' => 'hehe@gmail.com',
                'so_dien_thoai' => '0123456789',
                'ngay_sinh' => '2001-09-09',
                'cccd' => '123456789009',
                'id_chuc_vu' => 3,
                'trang_thai' => 'active',
                'avatar' => 'https://ik.imagekit.io/tvlk/blog/2022/02/dia-diem-du-lich-viet-nam-cover.jpeg',
                'hash_reset' => null,
                'hash_active' => null,
            ],
        ]);
    }
}
