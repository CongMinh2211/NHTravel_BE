<?php

namespace Database\Seeders;

use App\Models\ChatbotLog;
use Illuminate\Database\Seeder;

class ChatbotLogSeeder extends Seeder
{
    public function run()
    {
        ChatbotLog::insert([
            [
                'id_khach_hang' => 2,
                'noi_dung' => "KH: Tôi muốn đặt tour Đà Nẵng\nBot: Bạn muốn đặt ngày nào?",
            ],
        ]);
    }
}

