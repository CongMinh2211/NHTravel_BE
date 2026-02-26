<?php

namespace Database\Seeders;

use App\Models\TourAnh;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourAnhSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Xóa dữ liệu cũ để tránh trùng lặp khi seed lại
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = OFF;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); }
        DB::table('tour_anhs')->truncate();
        if (DB::getDriverName() === 'sqlite') { DB::statement('PRAGMA foreign_keys = ON;'); } else { DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); }

        $data = [];

        // Sử dụng loremflickr.com - luôn trả ảnh thật theo keyword
        // Format: https://loremflickr.com/{width}/{height}/{keyword1,keyword2}?lock={number}
        // ?lock=N để cố định ảnh (không random mỗi lần load)

        // --- 1. Tour Sapa - Fansipan (ID: 1) ---
        $data[] = ['id_tour' => 1, 'url' => 'https://loremflickr.com/800/500/sapa,vietnam,terraces?lock=1', 'mo_ta' => 'Ruộng bậc thang Sapa'];
        $data[] = ['id_tour' => 1, 'url' => 'https://loremflickr.com/800/500/fansipan,mountain?lock=2', 'mo_ta' => 'Đỉnh Fansipan'];
        $data[] = ['id_tour' => 1, 'url' => 'https://loremflickr.com/800/500/sapa,village,vietnam?lock=3', 'mo_ta' => 'Bản Cát Cát'];

        // --- 2. Tour Hạ Long (ID: 2) ---
        $data[] = ['id_tour' => 2, 'url' => 'https://loremflickr.com/800/500/halong,bay,vietnam?lock=4', 'mo_ta' => 'Vịnh Hạ Long'];
        $data[] = ['id_tour' => 2, 'url' => 'https://loremflickr.com/800/500/halong,cruise,boat?lock=5', 'mo_ta' => 'Du thuyền Hạ Long'];
        $data[] = ['id_tour' => 2, 'url' => 'https://loremflickr.com/800/500/halong,cave,vietnam?lock=6', 'mo_ta' => 'Hang Sửng Sốt'];

        // --- 3. Tour Ninh Bình (ID: 3) ---
        $data[] = ['id_tour' => 3, 'url' => 'https://loremflickr.com/800/500/ninhbinh,trangan,vietnam?lock=7', 'mo_ta' => 'Tràng An Ninh Bình'];
        $data[] = ['id_tour' => 3, 'url' => 'https://loremflickr.com/800/500/ninhbinh,pagoda,vietnam?lock=8', 'mo_ta' => 'Chùa Bái Đính'];
        $data[] = ['id_tour' => 3, 'url' => 'https://loremflickr.com/800/500/ninhbinh,river,boat?lock=9', 'mo_ta' => 'Tuyệt Tình Cốc'];

        // --- 4. Tour Hà Giang (ID: 4) ---
        $data[] = ['id_tour' => 4, 'url' => 'https://loremflickr.com/800/500/hagiang,mountain,vietnam?lock=10', 'mo_ta' => 'Đèo Mã Pí Lèng'];
        $data[] = ['id_tour' => 4, 'url' => 'https://loremflickr.com/800/500/hagiang,road,loop?lock=11', 'mo_ta' => 'Cung đường Hà Giang'];
        $data[] = ['id_tour' => 4, 'url' => 'https://loremflickr.com/800/500/vietnam,mountain,terraces?lock=12', 'mo_ta' => 'Cột cờ Lũng Cú'];

        // --- 5. Tour Hà Nội (ID: 5) ---
        $data[] = ['id_tour' => 5, 'url' => 'https://loremflickr.com/800/500/hanoi,lake,vietnam?lock=13', 'mo_ta' => 'Hồ Hoàn Kiếm'];
        $data[] = ['id_tour' => 5, 'url' => 'https://loremflickr.com/800/500/hanoi,temple,vietnam?lock=14', 'mo_ta' => 'Văn Miếu'];
        $data[] = ['id_tour' => 5, 'url' => 'https://loremflickr.com/800/500/hanoi,oldquarter,street?lock=15', 'mo_ta' => 'Phố cổ Hà Nội'];

        // --- 6. Tour Cao Bằng (ID: 6) ---
        $data[] = ['id_tour' => 6, 'url' => 'https://loremflickr.com/800/500/bangioc,waterfall,vietnam?lock=16', 'mo_ta' => 'Thác Bản Giốc'];
        $data[] = ['id_tour' => 6, 'url' => 'https://loremflickr.com/800/500/caobang,vietnam,nature?lock=17', 'mo_ta' => 'Thiên nhiên Cao Bằng'];
        $data[] = ['id_tour' => 6, 'url' => 'https://loremflickr.com/800/500/vietnam,waterfall,landscape?lock=18', 'mo_ta' => 'Hồ Thang Hen'];

        // --- 7. Tour Mộc Châu (ID: 7) ---
        $data[] = ['id_tour' => 7, 'url' => 'https://loremflickr.com/800/500/tea,hill,vietnam?lock=19', 'mo_ta' => 'Đồi chè Mộc Châu'];
        $data[] = ['id_tour' => 7, 'url' => 'https://loremflickr.com/800/500/pine,forest,vietnam?lock=20', 'mo_ta' => 'Rừng thông'];
        $data[] = ['id_tour' => 7, 'url' => 'https://loremflickr.com/800/500/plum,blossom,vietnam?lock=21', 'mo_ta' => 'Hoa mận Mộc Châu'];

        // --- 8. Tour Đà Nẵng - Hội An (ID: 8) ---
        $data[] = ['id_tour' => 8, 'url' => 'https://loremflickr.com/800/500/danang,goldenbridge,vietnam?lock=22', 'mo_ta' => 'Cầu Vàng Bà Nà Hills'];
        $data[] = ['id_tour' => 8, 'url' => 'https://loremflickr.com/800/500/hoian,lantern,vietnam?lock=23', 'mo_ta' => 'Phố cổ Hội An'];
        $data[] = ['id_tour' => 8, 'url' => 'https://loremflickr.com/800/500/danang,beach,vietnam?lock=24', 'mo_ta' => 'Biển Mỹ Khê'];

        // --- 9. Tour Huế (ID: 9) ---
        $data[] = ['id_tour' => 9, 'url' => 'https://loremflickr.com/800/500/hue,citadel,vietnam?lock=25', 'mo_ta' => 'Đại Nội Huế'];
        $data[] = ['id_tour' => 9, 'url' => 'https://loremflickr.com/800/500/hue,tomb,vietnam?lock=26', 'mo_ta' => 'Lăng Khải Định'];
        $data[] = ['id_tour' => 9, 'url' => 'https://loremflickr.com/800/500/hue,perfume,river?lock=27', 'mo_ta' => 'Sông Hương'];

        // --- 10. Tour Nha Trang (ID: 10) ---
        $data[] = ['id_tour' => 10, 'url' => 'https://loremflickr.com/800/500/nhatrang,beach,vietnam?lock=28', 'mo_ta' => 'Biển Nha Trang'];
        $data[] = ['id_tour' => 10, 'url' => 'https://loremflickr.com/800/500/nhatrang,island,vietnam?lock=29', 'mo_ta' => 'Hòn Mun'];
        $data[] = ['id_tour' => 10, 'url' => 'https://loremflickr.com/800/500/ponagar,temple,vietnam?lock=30', 'mo_ta' => 'Tháp Bà Ponagar'];

        // --- 11. Tour Quy Nhơn (ID: 11) ---
        $data[] = ['id_tour' => 11, 'url' => 'https://loremflickr.com/800/500/quynhon,beach,vietnam?lock=31', 'mo_ta' => 'Biển Kỳ Co'];
        $data[] = ['id_tour' => 11, 'url' => 'https://loremflickr.com/800/500/eogio,cliff,vietnam?lock=32', 'mo_ta' => 'Eo Gió'];
        $data[] = ['id_tour' => 11, 'url' => 'https://loremflickr.com/800/500/phuyen,rocks,vietnam?lock=33', 'mo_ta' => 'Ghềnh Đá Đĩa'];

        // --- 12. Tour Đà Lạt (ID: 12) ---
        $data[] = ['id_tour' => 12, 'url' => 'https://loremflickr.com/800/500/dalat,city,vietnam?lock=34', 'mo_ta' => 'Thành phố Đà Lạt'];
        $data[] = ['id_tour' => 12, 'url' => 'https://loremflickr.com/800/500/dalat,flower,garden?lock=35', 'mo_ta' => 'Vườn hoa Đà Lạt'];
        $data[] = ['id_tour' => 12, 'url' => 'https://loremflickr.com/800/500/dalat,lake,vietnam?lock=36', 'mo_ta' => 'Hồ Xuân Hương'];

        // --- 13. Tour Mũi Né (ID: 13) ---
        $data[] = ['id_tour' => 13, 'url' => 'https://loremflickr.com/800/500/muine,sanddunes,vietnam?lock=37', 'mo_ta' => 'Đồi cát đỏ'];
        $data[] = ['id_tour' => 13, 'url' => 'https://loremflickr.com/800/500/muine,beach,vietnam?lock=38', 'mo_ta' => 'Biển Mũi Né'];
        $data[] = ['id_tour' => 13, 'url' => 'https://loremflickr.com/800/500/muine,fishing,boats?lock=39', 'mo_ta' => 'Thuyền thúng Mũi Né'];

        // --- 14. Tour Phú Quốc (ID: 14) ---
        $data[] = ['id_tour' => 14, 'url' => 'https://loremflickr.com/800/500/phuquoc,beach,vietnam?lock=40', 'mo_ta' => 'Bãi biển Phú Quốc'];
        $data[] = ['id_tour' => 14, 'url' => 'https://loremflickr.com/800/500/phuquoc,sunset,vietnam?lock=41', 'mo_ta' => 'Hoàng hôn Phú Quốc'];
        $data[] = ['id_tour' => 14, 'url' => 'https://loremflickr.com/800/500/phuquoc,island,vietnam?lock=42', 'mo_ta' => 'Bãi Sao'];

        // --- 15. Tour Miền Tây (ID: 15) ---
        $data[] = ['id_tour' => 15, 'url' => 'https://loremflickr.com/800/500/cantho,floating,market?lock=43', 'mo_ta' => 'Chợ nổi Cái Răng'];
        $data[] = ['id_tour' => 15, 'url' => 'https://loremflickr.com/800/500/mekong,delta,vietnam?lock=44', 'mo_ta' => 'Miền Tây sông nước'];
        $data[] = ['id_tour' => 15, 'url' => 'https://loremflickr.com/800/500/baclieu,vietnam,pagoda?lock=45', 'mo_ta' => 'Chùa Dơi Sóc Trăng'];

        // --- 16. Tour Côn Đảo (ID: 16) ---
        $data[] = ['id_tour' => 16, 'url' => 'https://loremflickr.com/800/500/condao,island,vietnam?lock=46', 'mo_ta' => 'Côn Đảo'];
        $data[] = ['id_tour' => 16, 'url' => 'https://loremflickr.com/800/500/condao,beach,tropical?lock=47', 'mo_ta' => 'Bãi Đầm Trầu'];
        $data[] = ['id_tour' => 16, 'url' => 'https://loremflickr.com/800/500/condao,prison,historic?lock=48', 'mo_ta' => 'Nhà tù Côn Đảo'];

        // --- 17. Tour Vũng Tàu (ID: 17) ---
        $data[] = ['id_tour' => 17, 'url' => 'https://loremflickr.com/800/500/vungtau,statue,christ?lock=49', 'mo_ta' => 'Tượng Chúa Kito'];
        $data[] = ['id_tour' => 17, 'url' => 'https://loremflickr.com/800/500/vungtau,lighthouse,vietnam?lock=50', 'mo_ta' => 'Hải đăng Vũng Tàu'];
        $data[] = ['id_tour' => 17, 'url' => 'https://loremflickr.com/800/500/vungtau,beach,vietnam?lock=51', 'mo_ta' => 'Bãi Sau'];

        // --- 18. Tour Sài Gòn (ID: 18) ---
        $data[] = ['id_tour' => 18, 'url' => 'https://loremflickr.com/800/500/saigon,skyline,vietnam?lock=52', 'mo_ta' => 'Skyline Sài Gòn'];
        $data[] = ['id_tour' => 18, 'url' => 'https://loremflickr.com/800/500/saigon,palace,vietnam?lock=53', 'mo_ta' => 'Dinh Độc Lập'];
        $data[] = ['id_tour' => 18, 'url' => 'https://loremflickr.com/800/500/saigon,notredame,cathedral?lock=54', 'mo_ta' => 'Nhà thờ Đức Bà'];

        // --- 19. Tour Đồng bằng sông Cửu Long (ID: 19) ---
        $data[] = ['id_tour' => 19, 'url' => 'https://loremflickr.com/800/500/mekong,river,vietnam?lock=55', 'mo_ta' => 'Sông nước Cửu Long'];
        $data[] = ['id_tour' => 19, 'url' => 'https://loremflickr.com/800/500/bentre,coconut,vietnam?lock=56', 'mo_ta' => 'Vườn trái cây Bến Tre'];
        $data[] = ['id_tour' => 19, 'url' => 'https://loremflickr.com/800/500/cantho,bridge,vietnam?lock=57', 'mo_ta' => 'Cầu Cần Thơ'];

        // --- 20. Tour Phan Thiết - Mũi Né (ID: 20) ---
        $data[] = ['id_tour' => 20, 'url' => 'https://loremflickr.com/800/500/phanthiet,sanddunes?lock=58', 'mo_ta' => 'Đồi cát Phan Thiết'];
        $data[] = ['id_tour' => 20, 'url' => 'https://loremflickr.com/800/500/phanthiet,beach,vietnam?lock=59', 'mo_ta' => 'Biển Phan Thiết'];
        $data[] = ['id_tour' => 20, 'url' => 'https://loremflickr.com/800/500/phanthiet,fishing,boats?lock=60', 'mo_ta' => 'Thuyền đánh cá'];

        TourAnh::insert($data);
    }
}

