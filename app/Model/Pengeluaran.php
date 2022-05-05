<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User','user_id', 'id');
    }
}
