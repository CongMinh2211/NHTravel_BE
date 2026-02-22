<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TourDuLich;
use App\Models\NguoiDung;

class DanhGia extends Model
{
    protected $table = 'danh_gias';

    protected $fillable = [
        'id_tour',
        'id_nguoi_dung',
        'hinh_anh',
        'diem',
        'binh_luan',
        'phan_hoi',
        'trang_thai',
    ];

    protected $casts = [
        'hinh_anh' => 'array',
    ];

    public function tour()
    {
        return $this->belongsTo(TourDuLich::class, 'id_tour');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung');
    }
}
