<?php

namespace Database\Seeders;

use App\Models\DanhMucBaiViet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucBaiVietSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Xóa dữ liệu cũ
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('danh_muc_bai_viets')->truncate();
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        // 2. Bộ dữ liệu mẫu phong phú (15 mục)
        $data = [
            [
                'ten_danh_muc' => 'Cẩm nang du lịch',
                'mo_ta'        => 'Tổng hợp kinh nghiệm, mẹo vặt cần thiết cho mọi chuyến đi.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Review điểm đến',
                'mo_ta'        => 'Đánh giá chân thực, chi tiết về các địa điểm hot nhất hiện nay.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Ẩm thực 3 miền',
                'mo_ta'        => 'Khám phá bản đồ ẩm thực đa dạng từ Bắc chí Nam.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Săn vé & Khuyến mãi',
                'mo_ta'        => 'Cập nhật các chương trình giảm giá, vé máy bay 0 đồng nhanh nhất.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Góc nhìn Lữ hành',
                'mo_ta'        => 'Những câu chuyện nghề, cảm nhận sâu sắc sau mỗi chuyến đi.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Văn hóa & Lễ hội',
                'mo_ta'        => 'Tìm hiểu nét đẹp văn hóa và các lễ hội đặc sắc vùng miền.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Check-in Sống ảo',
                'mo_ta'        => 'Top những địa điểm chụp ảnh đẹp "thần sầu" không thể bỏ qua.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Du lịch một mình (Solo)',
                'mo_ta'        => 'Kinh nghiệm và điểm đến an toàn cho người thích độc hành.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Du lịch Gia đình',
                'mo_ta'        => 'Gợi ý lịch trình phù hợp cho gia đình có người già và trẻ nhỏ.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Staycation & Nghỉ dưỡng',
                'mo_ta'        => 'Trải nghiệm các Resort, khách sạn 5 sao đẳng cấp.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Phượt & Khám phá',
                'mo_ta'        => 'Dành cho những đôi chân cuồng đi, thích chinh phục thử thách.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Visa & Thủ tục',
                'mo_ta'        => 'Hướng dẫn xin visa, hộ chiếu và các thủ tục xuất nhập cảnh.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Tin tức Du lịch',
                'mo_ta'        => 'Cập nhật tin tức nóng hổi về ngành du lịch trong và ngoài nước.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Du lịch Tâm linh',
                'mo_ta'        => 'Hành trình về những vùng đất thiêng, đền chùa nổi tiếng.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
            [
                'ten_danh_muc' => 'Mẹo vặt Hành lý',
                'mo_ta'        => 'Cách sắp xếp đồ đạc thông minh, gọn nhẹ cho mọi chuyến đi.',
                'created_at'   => now(), 'updated_at' => now(),
            ],
        ];

        DanhMucBaiViet::insert($data);
    }
}
