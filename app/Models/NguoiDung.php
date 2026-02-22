<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NguoiDung extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'nguoi_dungs';
    protected $fillable = [
        'ho_ten',
        'password',
        'email',
        'so_dien_thoai',
        'ngay_sinh',
        'cccd',
        'id_chuc_vu',
        'trang_thai',
        'avatar',
        'hash_reset',
        'hash_active',
    ];

    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'id_chuc_vu');
    }

    public function thongTinLienHes()
    {
        return $this->hasMany(ThongTinLienHe::class, 'id_nguoi_dung');
    }

    public function datTours()
    {
        return $this->hasMany(DatTour::class, 'id_khach_hang');
    }

    public function baiViets()
    {
        return $this->hasMany(BaiViet::class, 'id_tac_gia');
    }
}
