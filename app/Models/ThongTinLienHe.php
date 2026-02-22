<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongTinLienHe extends Model
{
    protected $table = 'thong_tin_lien_hes';
    protected $fillable = ['id_khach_hang', 'ten', 'email', 'so_dien_thoai', 'tin_nhan', 'trang_thai'];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung');
    }
}
