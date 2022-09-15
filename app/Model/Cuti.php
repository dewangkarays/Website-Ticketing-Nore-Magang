<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';

    public function karyawan() {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
    
}
