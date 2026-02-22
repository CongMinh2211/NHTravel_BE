<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichTrinh extends Model
{
    use HasFactory;

    protected $table = 'lich_trinhs';

    protected $fillable = [
        'id_tour',
        'ngay_lich_trinh',
        'thu_tu',
        'tieu_de',
        'noi_dung',
    ];

    // Mỗi lịch trình thuộc 1 tour
    public function tour()
    {
        return $this->belongsTo(TourDuLich::class, 'id_tour');
    }
}
