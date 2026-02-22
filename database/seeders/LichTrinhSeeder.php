<?php

namespace Database\Seeders;

use App\Models\LichTrinh;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LichTrinhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Xóa dữ liệu cũ (tùy chọn, nếu cần)
        // if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        // DB::table('lich_trinhs')->truncate();
        // if (DB::getDriverName() !== 'sqlite') { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }
        
        $now = Carbon::now();

        $data = [
            // ================================================================
            // TOUR 1: Sapa – Chinh phục đỉnh Fansipan (4 ngày) - ID_TOUR = 1
            // ================================================================
            [
                'id_tour' => 1,
                'ngay_lich_trinh' => 1,
                'thu_tu' => 1,
                'tieu_de' => 'Khởi hành Hà Nội – Di chuyển lên Sapa & Nhận phòng',
                'noi_dung' => '06:00: Xe và Hướng dẫn viên đón quý khách tại điểm hẹn ở Hà Nội. Khởi hành đi Sapa theo đường cao tốc Nội Bài – Lào Cai. Quý khách nghỉ ngơi trên xe. 
                            12:00: Đến Sapa, quý khách dùng bữa trưa với đặc sản núi rừng Tây Bắc.
                            Chiều: Nhận phòng khách sạn. Quý khách tự do khám phá thị trấn Sapa, tản bộ quanh Hồ Sapa, hoặc mua sắm tại Chợ Sapa.
                            Tối: Thưởng thức Lẩu Cá Hồi hoặc đồ nướng Sapa trong tiết trời se lạnh.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 1,
                'ngay_lich_trinh' => 2,
                'thu_tu' => 2,
                'tieu_de' => 'Chinh phục "Nóc nhà Đông Dương" Fansipan',
                'noi_dung' => 'Sáng: Sau bữa sáng, xe đưa quý khách đến ga cáp treo Fansipan. Quý khách trải nghiệm cáp treo 3 dây hiện đại nhất thế giới để lên đỉnh Fansipan, ngắm nhìn biển mây bồng bềnh và toàn cảnh thung lũng Mường Hoa.
                            Trưa: Ăn trưa tại khu vực chân núi hoặc đỉnh núi Fansipan.
                            Chiều: Tham quan **Bản Cát Cát**, nơi sinh sống của người H’Mông. Khám phá kiến trúc nhà cửa truyền thống, thác nước Cát Cát và tìm hiểu về nghề dệt thổ cẩm thủ công.
                            Tối: Tự do khám phá Sapa, dạo phố và thưởng thức cà phê.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 1,
                'ngay_lich_trinh' => 3,
                'thu_tu' => 3,
                'tieu_de' => 'Thác Bạc – Cổng Trời Ô Quy Hồ & Núi Hàm Rồng',
                'noi_dung' => 'Sáng: Tham quan **Thác Bạc** hùng vĩ và **Cổng Trời Ô Quy Hồ**, một trong "Tứ đại đỉnh đèo" của Việt Nam, nơi có tầm nhìn ngoạn mục ra thung lũng.
                            Trưa: Trở về trung tâm thị trấn Sapa ăn trưa.
                            Chiều: Khám phá **Núi Hàm Rồng**. Quý khách leo núi, chiêm ngưỡng Vườn hoa Châu Âu, Cổng Trời 1, Cổng Trời 2, và khu vực sân mây để chụp ảnh toàn cảnh thị trấn Sapa.
                            Tối: Tự do, chuẩn bị hành lý cho ngày về.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 1,
                'ngay_lich_trinh' => 4,
                'thu_tu' => 4,
                'tieu_de' => 'Sapa – Lào Cai – Trở về Hà Nội',
                'noi_dung' => 'Sáng: Tự do đi chợ mua sắm đặc sản địa phương (như nấm hương, măng khô, thuốc nam, thổ cẩm). Trả phòng khách sạn.
                            Trưa: Ăn trưa tại Sapa hoặc trên đường về.
                            Chiều: Xe đón đoàn di chuyển về Hà Nội.
                            18:00: Về đến Hà Nội, kết thúc chuyến đi. Hẹn gặp lại quý khách!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // ================================================================
            // TOUR 2: Du thuyền Hạ Long 5 sao - Ngủ đêm trên vịnh (2 ngày) - ID_TOUR = 2
            // ================================================================
            [
                'id_tour' => 2,
                'ngay_lich_trinh' => 1,
                'thu_tu' => 1,
                'tieu_de' => 'Khởi hành – Du thuyền Ambassador & Hang Sửng Sốt',
                'noi_dung' => '08:00: Đón khách tại Hà Nội và di chuyển đến Hạ Long. 
                            12:00: Làm thủ tục lên du thuyền 5 sao **Ambassador**, nhận phòng. Thưởng thức bữa trưa cao cấp trên Vịnh Hạ Long, ngắm nhìn hàng ngàn đảo đá vôi kỳ vĩ.
                            Chiều: Tham quan **Hang Sửng Sốt** – hang động lớn và đẹp nhất Vịnh Hạ Long. Sau đó, chèo Kayak hoặc bơi lội tại khu vực thanh bình.
                            Tối: Thưởng thức bữa tối lãng mạn trên du thuyền. Tự do câu mực đêm hoặc thư giãn tại quầy bar.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 2,
                'ngay_lich_trinh' => 2,
                'thu_tu' => 2,
                'tieu_de' => 'Đảo Ti Tốp – Trở về Hà Nội',
                'noi_dung' => 'Sáng: Tham gia lớp **Tập Thái Cực Quyền** đón bình minh trên boong tàu. Sau đó, dùng bữa sáng nhẹ.
                            09:00: Tham quan **Đảo Ti Tốp**. Quý khách có thể leo lên đỉnh để ngắm toàn cảnh Vịnh Hạ Long hoặc tắm biển tại bãi cát hình vầng trăng khuyết.
                            11:00: Trả phòng, dùng bữa trưa trên du thuyền khi tàu về bến. 
                            Chiều: Xe đón và đưa quý khách về Hà Nội, kết thúc chuyến đi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ================================================================
            // TOUR 3: Đà Nẵng – Hội An – Bà Nà Hills (4 ngày) - ID_TOUR = 8
            // ================================================================
            [
                'id_tour' => 8,
                'ngay_lich_trinh' => 1,
                'thu_tu' => 1,
                'tieu_de' => 'Đà Nẵng – Bán đảo Sơn Trà & Biển Mỹ Khê',
                'noi_dung' => '07:30: Đến Đà Nẵng (bằng phương tiện tự túc), xe đón quý khách về khách sạn nhận phòng.
                            Trưa: Ăn trưa, nghỉ ngơi.
                            Chiều: Tham quan **Bán đảo Sơn Trà**, viếng **Chùa Linh Ứng** với tượng Phật Quan Thế Âm cao nhất Việt Nam. Sau đó, tận hưởng làn nước mát lạnh tại bãi biển **Mỹ Khê** xinh đẹp.
                            Tối: Tự do dạo phố, ngắm **Cầu Rồng** phun lửa/nước (nếu là cuối tuần).',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 8,
                'ngay_lich_trinh' => 2,
                'thu_tu' => 2,
                'tieu_de' => 'Khám phá Tiên cảnh **Bà Nà Hills** & Cầu Vàng',
                'noi_dung' => 'Sáng: Sau bữa sáng, khởi hành đi Bà Nà Hills. Quý khách trải nghiệm cáp treo dài nhất thế giới. 
                            Tham quan **Cầu Vàng** nổi tiếng, **Vườn Hoa Le Jardin D’Amour**, **Hầm Rượu Debay** và **Làng Pháp** lãng mạn.
                            Trưa: Thưởng thức Buffet trưa tại nhà hàng trên Bà Nà.
                            Chiều: Vui chơi thỏa thích tại **Fantasy Park** với hơn 100 trò chơi miễn phí.
                            Tối: Quay về Đà Nẵng. Ăn tối và nghỉ đêm.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 8,
                'ngay_lich_trinh' => 3,
                'thu_tu' => 3,
                'tieu_de' => 'Hội An Phố Cổ – Làng Nghề & Tắm Biển',
                'noi_dung' => 'Sáng: Tham quan **Làng đá Non Nước** dưới chân núi Ngũ Hành Sơn.
                            Trưa: Ăn trưa tại Hội An.
                            Chiều: Khám phá **Phố cổ Hội An** - Di sản Văn hóa Thế giới: **Chùa Cầu Nhật Bản**, **Hội Quán Phúc Kiến**, nhà cổ trăm năm tuổi.
                            Tối: Thưởng thức bữa tối đặc sản Hội An (Cao Lầu, Bánh Vạc). Ngắm phố cổ lung linh ánh đèn lồng.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 8,
                'ngay_lich_trinh' => 4,
                'thu_tu' => 4,
                'tieu_de' => 'Mua sắm & Kết thúc hành trình',
                'noi_dung' => 'Sáng: Sau bữa sáng, quý khách tự do mua sắm đặc sản địa phương tại **Chợ Hàn** hoặc **Chợ Cồn** ở Đà Nẵng.
                            Trưa: Trả phòng khách sạn, dùng bữa trưa.
                            Chiều: Xe đưa quý khách ra sân bay hoặc ga tàu, kết thúc chuyến tham quan đầy thú vị.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ================================================================
            // TOUR 4: Phú Quốc 3N2Đ - Đảo Ngọc thiên đường (3 ngày) - ID_TOUR = 14
            // ================================================================
            [
                'id_tour' => 14,
                'ngay_lich_trinh' => 1,
                'thu_tu' => 1,
                'tieu_de' => 'Đến Phú Quốc – Bãi Sao & Sunset Sanato',
                'noi_dung' => '09:00: Đến Phú Quốc (bằng phương tiện tự túc), xe đón quý khách về Resort/Khách sạn 5 sao.
                            Trưa: Ăn trưa và nghỉ ngơi.
                            Chiều: Tham quan **Nhà tù Phú Quốc**, di tích lịch sử nổi tiếng. Sau đó, thư giãn và tắm biển tại **Bãi Sao** với bờ cát trắng mịn.
                            Tối: Ngắm hoàng hôn tại **Sunset Sanato Beach Club** với những kiến trúc độc đáo, sau đó dùng bữa tối hải sản.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 14,
                'ngay_lich_trinh' => 2,
                'thu_tu' => 2,
                'tieu_de' => 'VinWonders/Vinpearl Safari & Grand World Phú Quốc',
                'noi_dung' => 'Sáng: Khởi hành đi **Vinpearl Safari** (Tùy chọn) – Công viên chăm sóc và bảo tồn động vật bán hoang dã.
                            Hoặc: Vui chơi tại **VinWonders Phú Quốc** – Công viên chủ đề lớn nhất Việt Nam.
                            Trưa: Ăn trưa tự túc trong khu vui chơi.
                            Chiều: Tiếp tục vui chơi.
                            Tối: Thăm quan **Grand World Phú Quốc** (Thành phố không ngủ), xem chương trình nhạc nước **Sắc màu Venice** hoành tráng và thưởng thức ẩm thực đường phố.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tour' => 14,
                'ngay_lich_trinh' => 3,
                'thu_tu' => 3,
                'tieu_de' => 'Chợ Dương Đông – Mua sắm & Khởi hành về',
                'noi_dung' => 'Sáng: Thăm quan **Vườn tiêu** nổi tiếng Phú Quốc và nhà thùng **Nước mắm Phú Quốc** truyền thống. Sau đó, mua sắm hải sản khô và quà lưu niệm tại **Chợ Dương Đông**.
                            Trưa: Trả phòng khách sạn. Dùng bữa trưa.
                            Chiều: Xe đưa quý khách ra sân bay Phú Quốc. Kết thúc chương trình tour.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        LichTrinh::insert($data);
    }
}
