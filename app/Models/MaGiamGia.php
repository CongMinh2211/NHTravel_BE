<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    protected $table = 'ma_giam_gias';
    protected $fillable = ['ma', 'mo_ta', 'phan_tram_giam', 'hieu_luc_tu', 'hieu_luc_den', 'so_luong', 'tao_boi', 'trang_thai'];

    public function datTours()
    {
        return $this->hasMany(DatTour::class, 'id_ma_giam_gia');
    }

    public function lichSuKhuyenMais()
    {
        return $this->hasMany(LichSuKhuyenMai::class, 'id_ma_giam_gia');
    }
}
