<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourDuLich extends Model
{
    protected $table = 'tour_du_liches';
    protected $fillable = [
        'ma_tour',
        'ten_tour',
        'mo_ta',
        'id_danh_muc',
        'gia_nguoi_lon',
        'gia_tre_em',
        'ngay_di',
        'ngay_ve',
        'gio_di',
        'gio_ve',
        'dia_diem',
        'tao_boi',
        'so_cho',
        'so_cho_con',
        'trang_thai',
    ];



    public function lichTrinhs()
    {
        return $this->hasMany(LichTrinh::class, 'id_tour');
    }

    public function datTours()
    {
        return $this->hasMany(DatTour::class, 'id_tour');
    }

    public function phuongTiens()
    {
        return $this->belongsToMany(PhuongTien::class, 'tour_phuong_tiens', 'id_tour', 'id_phuong_tien');
    }

    // === 3 quan hệ BE đang gọi trong API ===

    // Quan hệ tới bảng danh mục tour
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'id_danh_muc');
    }

    // Quan hệ người tạo (user)
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'tao_boi');
    }

    public function anh()
    {
        return $this->hasMany(TourAnh::class, 'id_tour')->orderBy('id');
    }

    // Test thử
    // public function lichKhoiHanh()
    // {
    //     return $this->hasMany(LichKhoiHanh::class, 'id_tour', 'id');
    // }

    public function danhGia()
    {
        return $this->hasManyThrough(
            DanhGia::class,
            DatTour::class,
            'id_tour',       // khóa ngoại trong dat_tour
            'id_dat_tour',   // khóa ngoại trong danh_gia
            'id',            // khóa chính của tour
            'id'             // khóa chính của dat_tour
        );
    }
}
