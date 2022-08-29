<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyek extends Model
{
    use SoftDeletes;

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

    public function task(){
        return $this->hasMany('App\Model\Task','id_proyek','id');
    }

    public function rekapDpTagihan()
    {
        return $this->belongsTo('App\Model\RekapDptagihan', 'user_id', 'user_id');
    }

    public function rekapTagihan()
    {
        return $this->belongsTo('App\Model\RekapTagihan', 'user_id', 'user_id');
    }

}
