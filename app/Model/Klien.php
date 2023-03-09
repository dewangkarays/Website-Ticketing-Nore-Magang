<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    protected $table = 'kliens';

    public function marketing()
    {
        return $this->belongsTo('App\Model\User', 'marketing_id','id');
    }  
}

       
    