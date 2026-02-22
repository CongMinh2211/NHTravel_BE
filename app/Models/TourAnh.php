<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourAnh extends Model
{
    protected $table = 'tour_anhs';
    protected $fillable = ['id_tour', 'url', 'mo_ta'];

    public function tour()
    {
        return $this->belongsTo(TourDuLich::class, 'id_tour');
    }
}
