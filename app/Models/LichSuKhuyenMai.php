<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichSuKhuyenMai extends Model
{
    protected $table = 'lich_su_khuyen_mais';
    protected $fillable = ['id_khach_hang', 'id_ma_giam_gia', 'thoi_gian_su_dung'];

    public function khachHang()
    {
        return $this->belongsTo(NguoiDung::class, 'id_khach_hang');
    }

    public function maGiamGia()
    {
        return $this->belongsTo(MaGiamGia::class, 'id_ma_giam_gia');
    }
}
