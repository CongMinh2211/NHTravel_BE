<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'MAIL_MAILER: ' . config('mail.default') . PHP_EOL;
echo 'MAIL_HOST: ' . config('mail.mailers.smtp.host') . PHP_EOL;
echo 'MAIL_PORT: ' . config('mail.mailers.smtp.port') . PHP_EOL;
echo 'MAIL_USERNAME: ' . config('mail.mailers.smtp.username') . PHP_EOL;
echo 'MAIL_FROM: ' . config('mail.from.address') . PHP_EOL;
echo 'FRONTEND_URL: ' . env('FRONTEND_URL') . PHP_EOL;
echo 'DB_CONNECTION: ' . config('database.default') . PHP_EOL;

// Test dat tour with mail
echo PHP_EOL . '=== Test Store Booking ===' . PHP_EOL;

use App\Models\TourDuLich;
use App\Models\DatTour;
use App\Models\ThanhToan;

$tour = TourDuLich::first();
if ($tour) {
    echo 'Tour found: ' . $tour->ten_tour . PHP_EOL;
    echo 'So cho con: ' . $tour->so_cho_con . PHP_EOL;
    
    // Simulate booking
    $maDonHang = 'ORD' . now()->format('YmdHis') . rand(100,999);
    
    try {
        $booking = DatTour::create([
            'id_khach_hang'   => 1,
            'id_tour'         => $tour->id,
            'ma_don_hang'     => $maDonHang,
            'ngay_dat'        => now(),
            'so_nguoi_lon'    => 1,
            'so_tre_em'       => 0,
            'tong_tien'       => $tour->gia_nguoi_lon,
            'giam_gia'        => 0,
            'tien_thuc_nhan'  => $tour->gia_nguoi_lon,
            'id_ma_giam_gia'  => null,
            'ten_lien_lac'    => 'Test User',
            'email_lien_lac'  => 'tranminh6464aimbot@gmail.com',
            'so_dien_thoai_lien_lac' => '0369636310',
            'dia_chi_lien_lac' => 'Test Address',
            'trang_thai'      => 'da_thanh_toan',
        ]);
        echo 'Booking created: ID=' . $booking->id . ' MaDon=' . $maDonHang . PHP_EOL;
        
        // Create thanh toan
        $tt = ThanhToan::create([
            'id_dat_tour' => $booking->id,
            'phuong_thuc' => 'tien_mat',
            'so_tien' => $tour->gia_nguoi_lon,
            'trang_thai' => 'thanh_cong',
            'thoi_gian_thanh_toan' => now(),
        ]);
        echo 'ThanhToan created: ID=' . $tt->id . PHP_EOL;
        
        // Send mail
        $mailData = [
            'ten_lien_lac'    => 'Test User',
            'email_lien_lac'  => 'tranminh6464aimbot@gmail.com',
            'so_dien_thoai'   => '0369636310',
            'dia_chi'         => 'Test Address',
            'ma_don_hang'     => $maDonHang,
            'ten_tour'        => $tour->ten_tour,
            'ngay_dat'        => now()->format('d/m/Y H:i'),
            'ngay_khoi_hanh'  => $tour->ngay_khoi_hanh ? \Carbon\Carbon::parse($tour->ngay_khoi_hanh)->format('d/m/Y') : '',
            'so_nguoi_lon'    => 1,
            'so_tre_em'       => 0,
            'tong_tien'       => $tour->gia_nguoi_lon,
            'giam_gia'        => 0,
            'tien_thuc_nhan'  => $tour->gia_nguoi_lon,
            'phuong_thuc'     => 'Thanh toan khi di tour',
            'phuong_thuc_raw' => 'cash',
            'link_don_hang'   => env('FRONTEND_URL', 'https://nhtravel.vercel.app') . '/lich-su-don-hang',
        ];
        
        Illuminate\Support\Facades\Mail::to('tranminh6464aimbot@gmail.com')->send(
            new App\Mail\MasterMail('Test dat tour - ' . $maDonHang, 'xacNhanDatTour', $mailData)
        );
        echo 'Mail sent OK!' . PHP_EOL;
        
    } catch (\Exception $e) {
        echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
        echo 'File: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    }
} else {
    echo 'No tour found!' . PHP_EOL;
}
