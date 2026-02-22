<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DatTour;
use Carbon\Carbon;

class KiemTraThanhToan extends Command
{
    protected $signature = 'kiemtra:thanhtoan';
    protected $description = 'Kiểm tra đơn hàng chờ xử lý quá lâu và tự hủy';

    public function handle()
    {
        $donHangs = DatTour::where('trang_thai', 'cho_xu_ly')
            ->where('ngay_dat', '<=', now()->subMinutes(10)) // Đơn quá 10 phút chưa thanh toán
            ->get();

        foreach ($donHangs as $don) {
            $don->trang_thai = 'da_huy';
            $don->save();
        }

        $this->info("Đã hủy " . $donHangs->count() . " đơn quá hạn.");
    }
}
