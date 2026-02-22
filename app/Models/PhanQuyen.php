<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    protected $table = 'phan_quyens';

    protected $fillable = [
        'id_chuc_vu',
        'id_chuc_nang',
    ];

    // Quan hệ ngược về Chức Vụ
    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'id_chuc_vu');
    }

    // Quan hệ ngược về Chức Năng
    public function chucNang()
    {
        return $this->belongsTo(ChucNang::class, 'id_chuc_nang');
    }
}