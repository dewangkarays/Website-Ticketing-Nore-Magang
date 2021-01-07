<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function tagihan(){
        return $this->hasOne('App\Model\Tagihan','id_proyek','id');
    }
}
