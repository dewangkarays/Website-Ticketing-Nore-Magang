<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';

    public function karyawan() {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
    
    public function verifikator1() {
        return $this->belongsTo('App\Model\User', 'verifikator_1', 'id');
    }

    public function verifikator2() {
        return $this->belongsTo('App\Model\User', 'verifikator_2', 'id');
    }
}
