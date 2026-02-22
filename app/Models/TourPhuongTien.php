<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPhuongTien extends Model
{
    protected $table = 'tour_phuong_tiens';

    protected $fillable = [
        'id_tour',
        'id_phuong_tien',
        'ghi_chu',
    ];

    public function tour()
    {
        return $this->belongsTo(TourDuLich::class, 'id_tour');
    }

    public function phuongTien()
    {
        return $this->belongsTo(PhuongTien::class, 'id_phuong_tien');
    }
}