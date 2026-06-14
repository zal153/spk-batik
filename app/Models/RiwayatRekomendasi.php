<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatRekomendasi extends Model
{
    protected $guarded = [];

    protected $casts = [
        'preferences' => 'array',
        'results' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
