<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;

class ThongBaoController extends Controller
{
    public function getData()
    {
        return response()->json(['data' => ThongBao::orderByDesc('ngay_tao')->get()]);
    }
}


