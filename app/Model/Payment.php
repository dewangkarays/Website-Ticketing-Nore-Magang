<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function tagihan()
    {
        return $this->belongsTo('App\Model\Tagihan', 'tagihan_id', 'id');
    }
    public function rekaptagihan()
    {
        return $this->belongsTo('App\Model\RekapTagihan', 'rekap_tagihan_id', 'id');
    }
    public function rekapdptagihan()
    {
        return $this->belongsTo('App\Model\RekapDptagihan', 'rekap_dptagihan_id', 'id');
    }
}
