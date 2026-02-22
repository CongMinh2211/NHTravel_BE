<?php

namespace Database\Seeders;

use App\Models\DanhGia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhGiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. Xóa sạch dữ liệu cũ để tránh trùng lặp id hoặc lỗi khóa ngoại
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('danh_gias')->truncate();
        if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        $now = now();

        DanhGia::insert([
            // ================================================================
            // ID_TOUR = 1 (Tour Sapa) - Khách hàng ID 1 & 2
            // ================================================================
            [
                'id_tour' => 1,
                'id_nguoi_dung' => 1,
                'diem'          => 5,
                'binh_luan'     => 'Chuyến đi Sapa tuyệt vời, chinh phục Fansipan đúng như mong đợi. Hướng dẫn viên am hiểu kiến thức và rất nhiệt tình hỗ trợ đoàn.',
                'hinh_anh'      => json_encode([
                    'https://i.pinimg.com/736x/55/a4/db/55a4db3fab47aa3fae28cd53b8a1f515.jpg',
                    'https://i.pinimg.com/736x/29/ec/11/29ec11091a137fc7ba8f8fbef0cbce39.jpg'
                ]),
                'phan_hoi'      => 'Cảm ơn bạn đã tin tưởng NHTravel. Rất mong được phục vụ bạn trong những chuyến đi tiếp theo!',
                'trang_thai'    => 'hien_thi',
                'created_at'    => $now->subDays(10), 
                'updated_at'    => $now->subDays(10),
            ],
            [
                'id_tour' => 1,
                'id_nguoi_dung' => 2,
                'diem'          => 4,
                'binh_luan'     => 'Khách sạn sạch sẽ, đồ ăn ngon. Tuy nhiên, chuyến xe từ Hà Nội lên Sapa hơi rung lắc, mong công ty cải thiện phương tiện.',
                'hinh_anh'      => null,
                'phan_hoi'      => 'Thành thật xin lỗi quý khách về trải nghiệm di chuyển. Chúng tôi sẽ làm việc với đối tác vận tải để nâng cao chất lượng dịch vụ.',
                'trang_thai'    => 'hien_thi',
                'created_at'    => $now->subDays(8), 
                'updated_at'    => $now->subDays(8),
            ],
            
            // ================================================================
            // ID_TOUR = 8 (Tour Đà Nẵng) - Khách hàng ID 3 & 1 (dùng lại ID 1)
            // ================================================================
            [
                'id_tour' => 8,
                'id_nguoi_dung' => 3,
                'diem'          => 5,
                'binh_luan'     => 'Đà Nẵng quá đẹp! Cầu Vàng Bà Nà Hills là điểm nhấn. Lịch trình hợp lý, có đủ thời gian để vui chơi và thư giãn.',
                'hinh_anh'      => json_encode([
                    'https://i.pinimg.com/736x/d9/99/dc/d999dc458018240c8112b227a8424779.jpg',
                ]),
                'phan_hoi'      => null, // Chưa trả lời
                'trang_thai'    => 'hien_thi',
                'created_at'    => $now->subDays(5), 
                'updated_at'    => $now->subDays(5),
            ],
            [
                'id_tour' => 8,
                'id_nguoi_dung' => 1,
                'diem'          => 3,
                'binh_luan'     => 'Dịch vụ ổn. Điểm trừ là bữa tối ở Hội An hơi đông và ồn ào. Không có trải nghiệm đặc sắc nào về ẩm thực địa phương.',
                'hinh_anh'      => null,
                'phan_hoi'      => 'Chúng tôi đã ghi nhận phản hồi của quý khách và sẽ tìm kiếm những nhà hàng có không gian yên tĩnh, chất lượng ẩm thực tốt hơn cho các đoàn sau.',
                'trang_thai'    => 'hien_thi',
                'created_at'    => $now->subDays(4), 
                'updated_at'    => $now->subDays(4),
            ],
            
            // ================================================================
            // ID_TOUR = 14 (Tour Phú Quốc) - Đánh giá tiêu cực/chờ duyệt
            // ================================================================
            [
                'id_tour' => 14,
                'id_nguoi_dung' => 2,
                'diem'          => 1,
                'binh_luan'     => 'Hướng dẫn viên quá tệ, đi đâu cũng hối thúc, không cho khách thời gian chụp ảnh. Đây là lần cuối tôi sử dụng dịch vụ!',
                'hinh_anh'      => null,
                'phan_hoi'      => null,
                'trang_thai'    => 'cho_duyet', // Đang chờ duyệt (tiêu cực)
                'created_at'    => $now->subHours(5), 
                'updated_at'    => $now->subHours(5),
            ],
            [
                'id_tour' => 14,
                'id_nguoi_dung' => 3,
                'diem'          => 5,
                'binh_luan'     => 'Phú Quốc là thiên đường! Resort 5 sao như mơ. Rất đáng tiền!',
                'hinh_anh'      => json_encode(['https://i.pinimg.com/736x/0e/d9/d9/0ed9d9a76e98822f56e3380d6f7dadee.jpg']),
                'phan_hoi'      => 'Xin cảm ơn lời khen tuyệt vời của bạn. Hân hạnh được phục vụ!',
                'trang_thai'    => 'hien_thi',
                'created_at'    => $now->subDays(2), 
                'updated_at'    => $now->subDays(2),
            ],
        ]);
    }
}
