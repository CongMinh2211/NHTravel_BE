<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ThongTinLienHeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Các ID hợp lệ từ NguoiDungSeeder (ID 1 đến 4)
        $validUserIds = [1, 2, 3, 4];
        
        // Trạng thái hợp lệ
        $validTrangThai = ['chua_xem', 'da_xem', 'da_tra_loi'];

        // Lặp 10 lần (giảm xuống cho nhanh) để tạo bản ghi
        for ($i = 0; $i < 10; $i++) {
            
            // Logic cho id_khach_hang:
            // - 70% là NULL (Ẩn danh), 30% là ID ngẫu nhiên
            $isAnonymous = rand(1, 100) <= 70;
            $customerId = $isAnonymous ? null : $validUserIds[array_rand($validUserIds)];

            $ten = $isAnonymous ? 'Khách hàng ' . rand(100, 999) : 'Người dùng VIP ' . $customerId;

            DB::table('thong_tin_lien_hes')->insert([
                'id_khach_hang' => $customerId, 
                'ten' => $ten,
                'email' => 'contact' . $i . '@example.com',
                'so_dien_thoai' => '09' . rand(10000000, 99999999),
                'tin_nhan' => 'Đây là tin nhắn mẫu số ' . ($i + 1) . ' để kiểm tra hệ thống. Nội dung tin nhắn liên hệ từ khách hàng.',
                'trang_thai' => $validTrangThai[array_rand($validTrangThai)],
                'created_at' => now()->subDays(rand(1, 30)), 
                'updated_at' => now(),
            ]);
        }
    }
}
