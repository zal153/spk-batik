<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $guarded = [];

    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }
}
