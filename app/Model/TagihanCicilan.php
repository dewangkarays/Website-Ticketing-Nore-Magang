<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagihanCicilan extends Model
{
    use SoftDeletes;
    
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $table = 'tagihan_cicilan';

    public function tagihan()
    {
        return $this->belongsTo('App\Model\Tagihan', 'tagihan_id', 'id');
    }
    // public function rekapTagihan()
    // {
    //     return $this->belongsTo('App\Model\RekapTagihan', 'rekap_tagihan_id');
    // }


}
