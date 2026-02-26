<?php

namespace Database\Seeders;

use App\Models\BaiViet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiVietSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Xóa dữ liệu cũ
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = OFF;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('bai_viets')->truncate();
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = ON;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        $now = now();

        // 2. Tạo dữ liệu mẫu phong phú (14 bài)
        $data = [
            // --- DU LỊCH TRONG NƯỚC ---
            [
                'tieu_de'       => 'Top 10 địa điểm check-in "cháy máy" tại Đà Lạt 2025',
                'mo_ta_ngan'    => 'Tổng hợp những quán cafe, đồi thông và điểm săn mây mới toanh tại thành phố ngàn hoa.',
                'noi_dung'      => 'Nội dung chi tiết về Đà Lạt: Quảng trường Lâm Viên, Đồi chè Cầu Đất, Tiệm cafe Túi Mơ To...',
                'hinh_anh'      => 'https://www.vietnambooking.com/wp-content/uploads/2020/02/Bac-thang-len-hoi-ong-troi-Da-Lat.jpg',
                'tag'           => 'da-lat,check-in,san-may',
                'id_danh_muc'   => 7,
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Review chuyến đi Phú Quốc 4N3Đ chỉ với 5 triệu đồng',
                'mo_ta_ngan'    => 'Lịch trình chi tiết ăn chơi, ngủ nghỉ tiết kiệm mà vẫn sang chảnh tại Đảo Ngọc.',
                'noi_dung'      => 'Ngày 1: Đáp sân bay, check-in Sunset Sanato. Ngày 2: Đi tour 4 đảo...',
                'hinh_anh'      => 'https://cattour.vn/images/upload/images/Du-lich-phu-quoc/phu-quoc-thang-11/phu-quoc-4-ngay-3-dem-5.jpg',
                'tag'           => 'phu-quoc,review,tiet-kiem',
                'id_danh_muc'   => 2,
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Food Tour Hải Phòng: Ăn sập đất Cảng trong 24h',
                'mo_ta_ngan'    => 'Bánh đa cua, bánh mì que, dừa dầm... những món ngon không thể bỏ lỡ.',
                'noi_dung'      => 'Danh sách quán ngon: Bánh đa cua Bà Cụ, Ốc Thủy Dương...',
                'hinh_anh'      => 'https://cdnv2.tgdd.vn/bhx-static/bhx/News/Images/2025/10/21/1584611/image1_202510212238499155.jpg',
                'tag'           => 'hai-phong,food-tour,am-thuc',
                'id_danh_muc'   => 3,
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],

            // --- MẸO DU LỊCH & KHUYẾN MÃI ---
            [
                'tieu_de'       => 'Bí kíp săn vé máy bay 0 đồng cho người mới',
                'mo_ta_ngan'    => 'Hướng dẫn chi tiết cách canh giờ vàng, sử dụng thẻ thanh toán để săn vé rẻ.',
                'noi_dung'      => 'Chuẩn bị thẻ Visa/Mastercard, canh khung giờ 12h trưa...',
                'hinh_anh'      => 'https://www.etrip4u.com/Content/userfiles/bi-quyet-san-ve-may-bay-0-dong-de-thanh-cong-nhat.jpg',
                'tag'           => 've-may-bay,khuyen-mai,tips',
                'id_danh_muc'   => 4,
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => '5 Vật dụng "nhỏ nhưng có võ" khi đi du lịch một mình',
                'mo_ta_ngan'    => 'Solo Travel cần chuẩn bị gì để an toàn và thuận tiện nhất?',
                'noi_dung'      => '1. Sạc dự phòng. 2. Túi thuốc cá nhân. 3. Chân máy ảnh mini...',
                'hinh_anh'      => 'https://afamilycdn.com/150157425591193600/2022/8/28/photo-1-16616836821421052611285-1661684493766-1661684493909288285091.jpg',
                'tag'           => 'solo-travel,kinh-nghiem,meo-vat',
                'id_danh_muc'   => 8,
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],

            // --- NỘI BỘ & CAO CẤP ---
            [
                'tieu_de'       => '[Nháp] Kế hoạch marketing du lịch hè 2025',
                'mo_ta_ngan'    => 'Bài viết nội bộ chưa công khai.',
                'noi_dung'      => 'Chiến lược đẩy mạnh tour biển đảo...',
                'hinh_anh'      => 'https://cdn.thuvienphapluat.vn/phap-luat/2022-2/NM/du-lich.jpg',
                'tag'           => 'noi-bo',
                'id_danh_muc'   => 13,
                'tinh_trang'    => 'nhap', // Nháp
                'created_at'    => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Trải nghiệm nghỉ dưỡng tại Amanoi Ninh Thuận - Resort 6 sao',
                'mo_ta_ngan'    => 'Đẳng cấp nghỉ dưỡng xa hoa bậc nhất Việt Nam có gì?',
                'noi_dung'      => 'Kiến trúc độc đáo, dịch vụ quản gia riêng...',
                'hinh_anh'      => 'https://khachsandayroi.com/wp-content/uploads/2022/06/amanoi-resort-ninh-thuan.jpg',
                'tag'           => 'nghi-duong,resort,ninh-thuan',
                'id_danh_muc'   => 10,
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],

            // --- BÀI VIẾT MỚI BỔ SUNG ---
            [
                'tieu_de'       => 'Thủ tục xin Visa Hàn Quốc tự túc mới nhất 2025',
                'mo_ta_ngan'    => 'Cập nhật hồ sơ, chi phí và kinh nghiệm phỏng vấn đậu visa 99%.',
                'noi_dung'      => 'Chứng minh tài chính, lịch trình chi tiết...',
                'hinh_anh'      => 'https://ismhr.vn/datafiles/32579/upload/images/visa-du-hoc-han-quoc-2025.jpg',
                'tag'           => 'visa,han-quoc,thu-tuc',
                'id_danh_muc'   => 12, // Visa & Thủ tục
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Khám phá Chùa Tam Chúc - Ngôi chùa lớn nhất thế giới tại Hà Nam',
                'mo_ta_ngan'    => 'Điểm đến tâm linh hùng vĩ, sơn thủy hữu tình thu hút hàng triệu du khách.',
                'noi_dung'      => 'Lịch trình tham quan chùa, giá vé thuyền...',
                'hinh_anh'      => 'https://dulichokela.com/wp-content/uploads/2023/12/chua-tam-chuc-ha-nam.jpg',
                'tag'           => 'tam-linh,chua-tam-chuc,ha-nam',
                'id_danh_muc'   => 14, // Du lịch Tâm linh
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Lễ hội Pháo hoa Quốc tế Đà Nẵng DIFF 2025 trở lại',
                'mo_ta_ngan'    => 'Lịch thi đấu, giá vé và các đội tham dự lễ hội pháo hoa năm nay.',
                'noi_dung'      => 'Chủ đề năm nay là "Thế giới không khoảng cách"...',
                'hinh_anh'      => 'https://vietliketravel.vn/images/news/2025/05/20/compress/gia-ve-le-hoi-phao-hoa-da-nang-diff-2025-740_1747708566.jpg',
                'tag'           => 'le-hoi,phao-hoa,da-nang',
                'id_danh_muc'   => 4, // Tin tức sự kiện
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Gợi ý 5 set đồ "chất lừ" cho chuyến đi biển mùa hè',
                'mo_ta_ngan'    => 'Mặc gì để lên hình đẹp? Phối đồ đi biển sao cho sành điệu?',
                'noi_dung'      => 'Váy maxi, bikini kết hợp áo lưới, mũ cói...',
                'hinh_anh'      => 'https://file.hstatic.net/1000184601/article/phoi-do-mua-he_cd2830c09155482c96b1077882f028a9.jpg',
                'tag'           => 'thoi-trang,bien,song-ao',
                'id_danh_muc'   => 15, // Mẹo vặt (Hành lý)
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Hành trình xuyên Việt bằng xe máy của chàng trai 9x',
                'mo_ta_ngan'    => 'Câu chuyện đầy cảm hứng về chuyến đi 30 ngày dọc chiều dài đất nước.',
                'noi_dung'      => 'Những cung đường đèo hiểm trở, những người bạn mới quen...',
                'hinh_anh'      => 'https://kenh14cdn.com/2019/4/17/photo-1-15554938204871893103770.jpg',
                'tag'           => 'phuot,xuyen-viet,cam-hung',
                'id_danh_muc'   => 5, // Góc nhìn Lữ hành
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => 'Top 5 Homestay Đà Lạt view đồi thông đẹp ngất ngây',
                'mo_ta_ngan'    => 'Những căn nhà gỗ nhỏ xinh nằm giữa rừng thông, thích hợp để "trốn" khói bụi.',
                'noi_dung'      => 'Cú Trên Cây, Đợi Một Người, Leng Keng...',
                'hinh_anh'      => 'https://dulichviet.com.vn/images/bandidau/top-5-homestay-view-doi-thong-cuc-xin-danh-cho-khach-du-lich-da-lat.jpg',
                'tag'           => 'da-lat,homestay,review',
                'id_danh_muc'   => 2,
                'tinh_trang'    => 'xuat_ban', 'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'tieu_de'       => '[Ẩn] Chiến dịch quảng cáo Tết 2026',
                'mo_ta_ngan'    => 'Nội dung chưa hoàn thiện.',
                'noi_dung'      => 'Draft...',
                'hinh_anh'      => 'https://marketingai.mediacdn.vn/thumb_w/640/603488451643117568/2025/11/22/xu-huong-truyen-thong-tet-17637821367791141851422.jpg',
                'tag'           => 'noi-bo',
                'id_danh_muc'   => 13,
                'tinh_trang'    => 'nhap', // Nháp
                'created_at'    => $now, 'updated_at' => $now,
            ],
        ];

        BaiViet::insert($data);
    }
}

