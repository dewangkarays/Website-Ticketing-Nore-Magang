<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $guarded = [
        'id', 'created_at'
    ];

    public function attachment()
    {
        return $this->hasMany('App\Model\Attachment');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');
    }

    public function assign()
    {
        return $this->belongsTo('App\Model\User', 'handler', 'id');
    }

    public function proyek(){
        return $this->belongsTo('App\Model\Proyek', 'id_proyek', 'id');
    }
}
