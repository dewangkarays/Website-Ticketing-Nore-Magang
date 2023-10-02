<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patchlist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patchlist', 'prioritas', 'kesulitan', 'status', 'tanggal_patch', 'keterangan', 'klien_id', 'proyek_id', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'klien_id');
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

}
