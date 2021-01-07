<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
    
    public function payment()
    {
        return $this->hasMany('App\Model\Payment', 'tagihan_id', 'id');
    }

    public function lampiran_gambar()
    {
        return $this->hasMany('App\Model\Lampiran_gambar', 'tagihan_id', 'id');
    }

    public function proyek()
    {
        return $this->belongsTo('App\Model\Proyek','id_proyek','id');
    }
}
