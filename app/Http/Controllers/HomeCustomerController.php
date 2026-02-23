<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use App\Models\DanhGia;
use App\Models\TourDuLich;
use Illuminate\Http\Request;

class HomeCustomerController
{
    public function homepageData()
    {
        $data_tour = TourDuLich::where('trang_thai', 'hoat_dong')
            ->with('anh') // lấy kèm ảnh
            ->orderBy('created_at', 'desc')
            ->get();

        $data_bv = BaiViet::where('tinh_trang', 'xuat_ban')   // chỉ lấy bài đã xuất bản
            ->orderBy('created_at', 'desc')       // bài mới nhất
            ->take(6)                             // chỉ lấy 6 bài
            ->get();
        return response()->json([
            'data_tour' => $data_tour,
            'data_bv' => $data_bv
        ]);
    }

    public function getDanhGia()
    {
        $danhgias = DanhGia::with('nguoiDung:id,ho_ten,avatar')
            ->where('diem', 5)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json($danhgias);
    }

    public function suggestTour(Request $request)
    {
        $location = $request->input('location');
        if (!$location) {
            return response()->json([]);
        }

        // Map các tên tỉnh/thành phố thường gọi vs tên trong database
        $locationMapping = [
            // Miền Bắc
            'hà nội' => ['Hà Nội'], 'hanoi' => ['Hà Nội'],
            'lào cai' => ['Lào Cai'], 'sapa' => ['Lào Cai'],
            'quảng ninh' => ['Quảng Ninh'], 'hạ long' => ['Quảng Ninh'],
            'ninh bình' => ['Ninh Bình'], 'hà giang' => ['Hà Giang'],
            'cao bằng' => ['Cao Bằng'], 'sơn la' => ['Sơn La'],
            'mộc châu' => ['Sơn La'], 'lai châu' => ['Lai Châu'],
            'điện biên' => ['Điện Biên'], 'yên bái' => ['Yên Bái'],
            'thái nguyên' => ['Thái Nguyên'], 'lạng sơn' => ['Lạng Sơn'],
            'phú thọ' => ['Phú Thọ'], 'bắc giang' => ['Bắc Giang'],
            'bắc ninh' => ['Bắc Ninh'], 'hải dương' => ['Hải Dương'],
            'hải phòng' => ['Hải Phòng'], 'hưng yên' => ['Hưng Yên'],
            'nam định' => ['Nam Định'], 'thái bình' => ['Thái Bình'],
            'hà nam' => ['Hà Nam'], 'vĩnh phúc' => ['Vĩnh Phúc'],
            'tuyên quang' => ['Tuyên Quang'], 'bắc kạn' => ['Bắc Kạn'],
            'hòa bình' => ['Hòa Bình'],
            // Miền Trung
            'thanh hóa' => ['Thanh Hóa'], 'nghệ an' => ['Nghệ An'],
            'hà tĩnh' => ['Hà Tĩnh'], 'quảng bình' => ['Quảng Bình'],
            'quảng trị' => ['Quảng Trị'],
            'huế' => ['Thừa Thiên Huế'], 'hue' => ['Thừa Thiên Huế'],
            'thừa thiên huế' => ['Thừa Thiên Huế'],
            'đà nẵng' => ['Đà Nẵng'], 'da nang' => ['Đà Nẵng'],
            'hội an' => ['Đà Nẵng'], 'quảng nam' => ['Quảng Nam'],
            'quảng ngãi' => ['Quảng Ngãi'],
            'bình định' => ['Bình Định'], 'quy nhơn' => ['Bình Định'],
            'phú yên' => ['Phú Yên'],
            'khánh hòa' => ['Khánh Hòa'], 'nha trang' => ['Khánh Hòa'],
            'ninh thuận' => ['Ninh Thuận'],
            'bình thuận' => ['Bình Thuận'], 'phan thiết' => ['Bình Thuận'],
            'mũi né' => ['Bình Thuận'],
            // Tây Nguyên
            'gia lai' => ['Gia Lai'], 'kon tum' => ['Kon Tum'],
            'đắk lắk' => ['Đắk Lắk'], 'đắk nông' => ['Đắk Nông'],
            'lâm đồng' => ['Lâm Đồng'], 'đà lạt' => ['Lâm Đồng'],
            // Miền Nam
            'tp hcm' => ['TP. Hồ Chí Minh'], 'hồ chí minh' => ['TP. Hồ Chí Minh'],
            'sài gòn' => ['TP. Hồ Chí Minh'],
            'bình dương' => ['Bình Dương'], 'đồng nai' => ['Đồng Nai'],
            'bình phước' => ['Bình Phước'], 'tây ninh' => ['Tây Ninh'],
            'bà rịa' => ['Bà Rịa - Vũng Tàu'], 'vũng tàu' => ['Bà Rịa - Vũng Tàu'],
            'côn đảo' => ['Bà Rịa - Vũng Tàu'],
            'long an' => ['Long An'], 'tiền giang' => ['Tiền Giang'],
            'bến tre' => ['Bến Tre'], 'trà vinh' => ['Trà Vinh'],
            'vĩnh long' => ['Vĩnh Long'], 'đồng tháp' => ['Đồng Tháp'],
            'an giang' => ['An Giang'], 'kiên giang' => ['Kiên Giang'],
            'phú quốc' => ['Kiên Giang'],
            'cần thơ' => ['Cần Thơ'], 'hậu giang' => ['Hậu Giang'],
            'sóc trăng' => ['Sóc Trăng'], 'bạc liêu' => ['Bạc Liêu'],
            'cà mau' => ['Cà Mau'],
        ];

        // Mapping tỉnh lân cận (tỉnh hiện tại → các tỉnh gần để gợi ý tour)
        $nearbyMapping = [
            // Tây Nguyên → gợi ý Miền Trung + Đà Lạt
            'Gia Lai' => ['Bình Định', 'Khánh Hòa', 'Đà Nẵng', 'Lâm Đồng'],
            'Kon Tum' => ['Đà Nẵng', 'Bình Định', 'Gia Lai', 'Lâm Đồng'],
            'Đắk Lắk' => ['Khánh Hòa', 'Lâm Đồng', 'Bình Định', 'TP. Hồ Chí Minh'],
            'Đắk Nông' => ['Lâm Đồng', 'Bình Thuận', 'TP. Hồ Chí Minh'],
            'Lâm Đồng' => ['Khánh Hòa', 'Bình Thuận', 'TP. Hồ Chí Minh'],
            // Miền Bắc
            'Hà Nội' => ['Quảng Ninh', 'Ninh Bình', 'Lào Cai', 'Hà Giang'],
            'Lào Cai' => ['Hà Giang', 'Hà Nội', 'Sơn La'],
            'Quảng Ninh' => ['Hà Nội', 'Ninh Bình', 'Lào Cai'],
            'Ninh Bình' => ['Hà Nội', 'Quảng Ninh', 'Lào Cai'],
            'Hà Giang' => ['Lào Cai', 'Cao Bằng', 'Hà Nội'],
            'Cao Bằng' => ['Hà Giang', 'Lào Cai', 'Hà Nội'],
            'Sơn La' => ['Lào Cai', 'Hà Nội', 'Hà Giang'],
            'Hải Phòng' => ['Quảng Ninh', 'Hà Nội', 'Ninh Bình'],
            'Thái Nguyên' => ['Hà Nội', 'Lào Cai', 'Quảng Ninh'],
            'Phú Thọ' => ['Hà Nội', 'Lào Cai', 'Sơn La'],
            'Bắc Giang' => ['Hà Nội', 'Quảng Ninh', 'Lào Cai'],
            'Bắc Ninh' => ['Hà Nội', 'Quảng Ninh', 'Ninh Bình'],
            'Hải Dương' => ['Hà Nội', 'Quảng Ninh', 'Ninh Bình'],
            'Hưng Yên' => ['Hà Nội', 'Quảng Ninh', 'Ninh Bình'],
            'Nam Định' => ['Ninh Bình', 'Hà Nội', 'Quảng Ninh'],
            'Thái Bình' => ['Ninh Bình', 'Hà Nội', 'Quảng Ninh'],
            'Hà Nam' => ['Ninh Bình', 'Hà Nội'],
            'Hòa Bình' => ['Hà Nội', 'Sơn La', 'Ninh Bình'],
            'Vĩnh Phúc' => ['Hà Nội', 'Lào Cai', 'Quảng Ninh'],
            'Tuyên Quang' => ['Hà Giang', 'Lào Cai', 'Hà Nội'],
            'Bắc Kạn' => ['Cao Bằng', 'Hà Nội', 'Lào Cai'],
            'Lai Châu' => ['Lào Cai', 'Sơn La', 'Hà Giang'],
            'Điện Biên' => ['Sơn La', 'Lào Cai', 'Hà Nội'],
            'Yên Bái' => ['Lào Cai', 'Hà Giang', 'Hà Nội'],
            'Lạng Sơn' => ['Cao Bằng', 'Hà Nội', 'Quảng Ninh'],
            // Miền Trung
            'Thanh Hóa' => ['Ninh Bình', 'Hà Nội', 'Quảng Bình'],
            'Nghệ An' => ['Hà Nội', 'Quảng Bình', 'Thừa Thiên Huế'],
            'Hà Tĩnh' => ['Quảng Bình', 'Thừa Thiên Huế', 'Đà Nẵng'],
            'Quảng Bình' => ['Thừa Thiên Huế', 'Đà Nẵng', 'Hà Nội'],
            'Quảng Trị' => ['Thừa Thiên Huế', 'Đà Nẵng', 'Quảng Bình'],
            'Thừa Thiên Huế' => ['Đà Nẵng', 'Bình Định', 'Khánh Hòa'],
            'Đà Nẵng' => ['Thừa Thiên Huế', 'Bình Định', 'Khánh Hòa'],
            'Quảng Nam' => ['Đà Nẵng', 'Thừa Thiên Huế', 'Bình Định'],
            'Quảng Ngãi' => ['Đà Nẵng', 'Bình Định', 'Khánh Hòa'],
            'Bình Định' => ['Khánh Hòa', 'Đà Nẵng', 'Lâm Đồng'],
            'Phú Yên' => ['Khánh Hòa', 'Bình Định', 'Đà Nẵng'],
            'Khánh Hòa' => ['Bình Định', 'Lâm Đồng', 'Bình Thuận'],
            'Ninh Thuận' => ['Khánh Hòa', 'Bình Thuận', 'Lâm Đồng'],
            'Bình Thuận' => ['Khánh Hòa', 'Lâm Đồng', 'TP. Hồ Chí Minh'],
            // Miền Nam
            'TP. Hồ Chí Minh' => ['Bà Rịa - Vũng Tàu', 'Lâm Đồng', 'Cần Thơ', 'Kiên Giang'],
            'Bình Dương' => ['TP. Hồ Chí Minh', 'Lâm Đồng', 'Bà Rịa - Vũng Tàu'],
            'Đồng Nai' => ['TP. Hồ Chí Minh', 'Bà Rịa - Vũng Tàu', 'Lâm Đồng'],
            'Bình Phước' => ['TP. Hồ Chí Minh', 'Lâm Đồng'],
            'Tây Ninh' => ['TP. Hồ Chí Minh', 'Cần Thơ'],
            'Bà Rịa - Vũng Tàu' => ['TP. Hồ Chí Minh', 'Lâm Đồng', 'Cần Thơ'],
            'Long An' => ['TP. Hồ Chí Minh', 'Cần Thơ', 'Kiên Giang'],
            'Tiền Giang' => ['Cần Thơ', 'TP. Hồ Chí Minh', 'Kiên Giang'],
            'Bến Tre' => ['Cần Thơ', 'TP. Hồ Chí Minh', 'Kiên Giang'],
            'Trà Vinh' => ['Cần Thơ', 'TP. Hồ Chí Minh'],
            'Vĩnh Long' => ['Cần Thơ', 'TP. Hồ Chí Minh'],
            'Đồng Tháp' => ['Cần Thơ', 'TP. Hồ Chí Minh', 'Kiên Giang'],
            'An Giang' => ['Cần Thơ', 'Kiên Giang', 'TP. Hồ Chí Minh'],
            'Kiên Giang' => ['Cần Thơ', 'TP. Hồ Chí Minh'],
            'Cần Thơ' => ['Kiên Giang', 'TP. Hồ Chí Minh', 'Bà Rịa - Vũng Tàu'],
            'Hậu Giang' => ['Cần Thơ', 'Kiên Giang', 'TP. Hồ Chí Minh'],
            'Sóc Trăng' => ['Cần Thơ', 'Kiên Giang'],
            'Bạc Liêu' => ['Cần Thơ', 'Kiên Giang'],
            'Cà Mau' => ['Kiên Giang', 'Cần Thơ', 'TP. Hồ Chí Minh'],
        ];

        $locationLower = mb_strtolower($location, 'UTF-8');
        
        // Tìm tên tỉnh chuẩn từ input
        $standardName = $location;
        if (isset($locationMapping[$locationLower])) {
            $standardName = $locationMapping[$locationLower][0];
        }

        // Bước 1: Tìm tour ngay tại tỉnh hiện tại
        $searchLocations = [$standardName, $location];
        $directTours = TourDuLich::where('trang_thai', 'hoat_dong')
            ->where(function($query) use ($searchLocations) {
                foreach ($searchLocations as $loc) {
                    $query->orWhere('dia_diem', 'like', '%' . $loc . '%');
                }
            })
            ->with('anh')
            ->take(3)
            ->get();

        // Bước 2: Tìm tour ở các tỉnh lân cận (2-3 tour mỗi tỉnh)
        $nearbyTours = collect();
        if (isset($nearbyMapping[$standardName])) {
            $nearbyProvinces = $nearbyMapping[$standardName];
            foreach ($nearbyProvinces as $province) {
                if ($nearbyTours->count() + $directTours->count() >= 8) break;
                
                $tours = TourDuLich::where('trang_thai', 'hoat_dong')
                    ->where('dia_diem', 'like', '%' . $province . '%')
                    ->with('anh')
                    ->take(2)
                    ->get();
                $nearbyTours = $nearbyTours->merge($tours);
            }
        }

        $allTours = $directTours->merge($nearbyTours)->unique('id')->take(8);

        // Nếu vẫn ít hơn 4 tour → bổ sung tour random
        if ($allTours->count() < 4) {
            $excludeIds = $allTours->pluck('id')->toArray();
            $extraTours = TourDuLich::where('trang_thai', 'hoat_dong')
                ->whereNotIn('id', $excludeIds)
                ->with('anh')
                ->inRandomOrder()
                ->take(8 - $allTours->count())
                ->get();
            $allTours = $allTours->merge($extraTours);
        }

        return response()->json($allTours->values());
    }
}
