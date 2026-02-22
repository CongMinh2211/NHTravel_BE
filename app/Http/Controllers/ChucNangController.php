<?php

namespace App\Http\Controllers;

use App\Models\ChucNang;
use Illuminate\Http\Request;

class ChucNangController
{
    public function getData()
    {
        $data = ChucNang::all();

        return response()->json([
            'success' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $data
        ]);
    }
}
