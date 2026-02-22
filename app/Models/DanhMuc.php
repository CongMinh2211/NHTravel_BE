<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    protected $table = 'danh_mucs';
    protected $fillable = ['ten_danh_muc', 'mo_ta'];

    public function tourDuLiches()
    {
        return $this->hasMany(TourDuLich::class, 'id_danh_muc');
    }
}
