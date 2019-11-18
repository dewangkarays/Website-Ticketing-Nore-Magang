<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];
}
