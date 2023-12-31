<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekapTagihan extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    public function tagihan()
    {
        return $this->hasMany('App\Model\Tagihan', 'rekap_tagihan_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
    
    public function payment()
    {
        return $this->hasMany('App\Model\Payment', 'rekap_tagihan_id', 'id');
    }

    public function proyeks()
    {
        return $this->hasMany('App\Model\Proyek', 'rekap_tagihan_id');
    }
    public function pembayaranCicilan()
    {
        return $this->hasOne('App\Model\TagihanCicilan', 'rekap_id', 'id');
    }

    public function pembayaranCicilanKosong()
    {
        return $this->hasMany('App\Model\TagihanCicilan', 'rekap_id', 'id')
            ->whereNull('rekap_id');
    }
}
