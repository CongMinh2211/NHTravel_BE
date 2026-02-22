<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuongTien extends Model
{
    protected $table = 'phuong_tiens';

    protected $fillable = [
        'ten_phuong_tien',
        'mo_ta',
        'bien_so',
        'suc_chua',
        'trang_thai',
    ];

    // Quan hệ nhiều-nhiều với Tour thông qua bảng trung gian
    public function tours()
    {
        return $this->belongsToMany(
            TourDuLich::class,
            'tour_phuong_tiens',
            'id_phuong_tien',   // Khóa ngoại của model hiện tại trong bảng pivot
            'id_tour'           // Khóa ngoại của model kia trong bảng pivot
        )
        ->withPivot([
            'ghi_chu',          // Chỉ lấy thêm ghi chú
            'created_at',
            'updated_at'
        ]);
    }
}