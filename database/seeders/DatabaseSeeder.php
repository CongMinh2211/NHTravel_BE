<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            // 1. CẤU HÌNH HỆ THỐNG (Chạy đầu tiên để có quyền hạn)
            ChucVuSeeder::class,
            ChucNangSeeder::class,    // Mới thêm
            PhanQuyenSeeder::class,   // Mới thêm (Phụ thuộc ChucVu & ChucNang)

            // 2. DANH MỤC CỐ ĐỊNH
            DanhMucSeeder::class,
            DanhMucBaiVietSeeder::class,
            PhuongTienSeeder::class,

            // 3. NGƯỜI DÙNG (Phụ thuộc ChucVu)
            NguoiDungSeeder::class,

            // 4. BẢNG TOUR (Core)
            TourDuLichSeeder::class,      // Phụ thuộc DanhMuc, NguoiDung
            TourAnhSeeder::class,         // Phụ thuộc Tour
            TourPhuongTienSeeder::class,  // Phụ thuộc Tour, PhuongTien

            // 5. BẢNG GIAO DỊCH & TƯƠNG TÁC
            MaGiamGiaSeeder::class,       // Phụ thuộc NguoiDung
            LichTrinhSeeder::class,       // Phụ thuộc Tour
            DatTourSeeder::class,         // Phụ thuộc NguoiDung, Tour, MaGiamGia
            ThanhToanSeeder::class,       // Phụ thuộc DatTour
            LichSuKhuyenMaiSeeder::class, // Phụ thuộc NguoiDung, MaGiamGia
            DanhGiaSeeder::class,         // Phụ thuộc DatTour

            // 6. THÔNG TIN BỔ SUNG
            // Phụ thuộc DanhMucBaiViet
            BaiVietSeeder::class,
            // ChatbotLogSeeder::class,
            ThongTinLienHeSeeder::class,
        ]);
    }
}

