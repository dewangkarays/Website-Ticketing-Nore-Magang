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
        return $this->hasMany('App\Model\Tagihan', 'tagihan_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
}
