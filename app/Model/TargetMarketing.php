<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetMarketing extends Model
{
    use SoftDeletes;
    
    protected $guarded = [
        'id', 'created_at'
    ];

    public function marketing()
    {
        return $this->belongsTo('App\Model\User', 'marketing_id', 'id');
    }

}
