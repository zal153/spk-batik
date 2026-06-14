<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaComparison extends Model
{
    protected $guarded = [];

    public function criteria1()
    {
        return $this->belongsTo(Kriteria::class, 'criteria_id_1');
    }

    public function criteria2()
    {
        return $this->belongsTo(Kriteria::class, 'criteria_id_2');
    }
}
