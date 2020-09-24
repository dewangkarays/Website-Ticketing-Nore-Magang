<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lampiran_gambar extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];
    
    public function tagihan()
    {
        return $this->belongsTo('App\Model\Tagihan', 'tagihan_id', 'id');
    }
}
