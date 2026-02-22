<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucBaiViet extends Model
{
    protected $table = 'danh_muc_bai_viets';
    protected $fillable = ['ten_danh_muc', 'mo_ta'];

    public function baiViets()
    {
        return $this->hasMany(BaiViet::class, 'id_danh_muc');
    }
}
