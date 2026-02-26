<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ThanhToan;

class DatTour extends Model
{
    protected $table = 'dat_tours';

    protected $fillable = [
        'id_khach_hang',
        'id_tour',
        'ma_don_hang',
        'ngay_dat',
        'so_nguoi_lon',
        'so_tre_em',
        'tong_tien',
        'giam_gia',
        'tien_thuc_nhan',
        'id_ma_giam_gia',
        'ten_lien_lac',
        'email_lien_lac',
        'so_dien_thoai_lien_lac',
        'dia_chi_lien_lac',
        'trang_thai',
        'id_phuong_tien',
        'ghi_chu'
    ];

    public function khachHang()
    {
        return $this->belongsTo(NguoiDung::class, 'id_khach_hang');
    }

    public function tour()
    {
        return $this->belongsTo(TourDuLich::class, 'id_tour');
    }

    public function thanhToan()
    {
        return $this->hasMany(ThanhToan::class, 'id_dat_tour');
    }

    public function phuongTien()
    {
        return $this->belongsTo(PhuongTien::class, 'id_phuong_tien');
    }

    public function voucher()
    {
        return $this->belongsTo(MaGiamGia::class, 'id_ma_giam_gia');
    }
}
