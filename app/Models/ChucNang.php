<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChucNang extends Model
{
    protected $table = 'chuc_nangs';

    protected $fillable = [
        'ten_chuc_nang',
    ];

    // Định nghĩa luôn quan hệ ngược với bảng phân quyền (dùng cho sau này)
    public function phanQuyens()
    {
        return $this->hasMany(PhanQuyen::class, 'id_chuc_nang');
    }
}