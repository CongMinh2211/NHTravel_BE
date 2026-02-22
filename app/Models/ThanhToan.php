<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toans';

    protected $fillable = [
        'id_dat_tour',
        'phuong_thuc',
        'thoi_gian_thanh_toan',
        'so_tien',
        'trang_thai',
    ];

    public function datTour()
    {
        return $this->belongsTo(DatTour::class, 'id_dat_tour');
    }
}
