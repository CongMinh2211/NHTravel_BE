<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ThongTinLienHeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Khởi tạo Faker với locale Việt Nam
        $faker = Faker::create('vi_VN'); 

        // Các ID hợp lệ từ NguoiDungSeeder (ID 1 đến 4)
        $validUserIds = [1, 2, 3, 4];
        
        // Trạng thái hợp lệ
        $validTrangThai = ['chua_xem', 'da_xem', 'da_tra_loi'];

        // Lặp 50 lần để tạo 50 bản ghi
        for ($i = 0; $i < 50; $i++) {
            
            // Logic cho id_khach_hang:
            // - Dùng optional(0.7) để 70% là NULL (Ẩn danh)
            // - 30% còn lại sẽ là ID ngẫu nhiên từ $validUserIds
            $customerId = $faker->optional(0.7, null)->randomElement($validUserIds);

            // Tên người gửi: Nếu là ẩn danh, tạo tên ngẫu nhiên. Nếu có ID, tên sẽ được lấy từ bảng nguoi_dungs (nhưng ở đây ta dùng Faker để giữ tính độc lập của Seeder)
            $ten = is_null($customerId) ? $faker->name : $faker->firstName . ' Khách hàng VIP';

            DB::table('thong_tin_lien_hes')->insert([
                'id_khach_hang' => $customerId, 
                'ten' => $ten,
                'email' => $faker->unique()->safeEmail,
                'so_dien_thoai' => $faker->phoneNumber,
                'tin_nhan' => $faker->realText(200),
                'trang_thai' => $faker->randomElement($validTrangThai),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'), 
                'updated_at' => now(),
            ]);
        }
    }
}