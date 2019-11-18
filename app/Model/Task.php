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
        return $this->hasMany('App\Comment');
    }
}
