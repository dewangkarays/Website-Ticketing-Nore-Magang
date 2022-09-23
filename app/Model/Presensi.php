<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    public function karyawan() {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }
}
