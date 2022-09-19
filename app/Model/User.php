<?php

namespace App\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // protected $dates = ['kadaluarsa'];

    protected $guarded = [
        'id', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'password' //, 'remember_token',
    ];

    public function task()
    {
        return $this->hasMany('App\Model\Task', 'user_id', 'id');
    }

    public function assign()
    {
        return $this->hasMany('App\Model\Task', 'handler', 'id');
    }

    public function payment()
    {
        return $this->hasMany('App\Model\Payment', 'user_id', 'id');
    }

    public function tagihan()
    {
        return $this->hasMany('App\Model\Tagihan', 'user_id', 'id');
    }

    public function proyek()
    {
        return $this->hasMany('App\Model\Proyek', 'user_id', 'id');
    }

    public function rekaptagihan()
    {
        return $this->hasMany('App\Model\RekapTagihan','user_id', 'id');
    }

    public function rekapdptagihan()
    {
        return $this->hasMany('App\Model\RekapDptagihan','user_id', 'id');
    }

    public function pengeluaran()
    {
        return $this->hasMany('App\Model\Pengeluaran','user_id', 'id');
    }

    public function cuti() {
        return $this->hasMany('App\Model\Cuti', 'user_id', 'id');
    }

    public function verifikasi1() {
        return $this->hasMany('App\Model\Cuti', 'verifikator_1_id', 'id');
    }

    public function verifikasi2() {
        return $this->hasMany('App\Model\Cuti', 'verifikator_2_id', 'id');
    }
}
