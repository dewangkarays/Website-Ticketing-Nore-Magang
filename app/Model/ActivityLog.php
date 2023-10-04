<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{

    protected $fillable = [
        'user_id',
        'activity_type',
        'patch_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}