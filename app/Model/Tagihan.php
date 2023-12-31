<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use SoftDeletes;
    
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

    public function rekaptagihan()
    {
        return $this->belongsTo('App\Model\RekapTagihan', 'rekap_tagihan_id', 'id');
    }
    public function rekapdptagihan()
    {
        return $this->belongsTo('App\Model\RekapDptagihan', 'rekap_dptagihan_id', 'id');
    }
    public function pembayaranCicilan()
    {
        return $this->hasMany('App\Model\TagihanCicilan', 'tagihan_id', 'id');
    }

    public function pembayaranCicilanKosong()
    {
        return $this->hasMany('App\Model\TagihanCicilan', 'tagihan_id', 'id')
            ->whereNull('rekap_id');
    }

}
