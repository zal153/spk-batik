<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCriteriaComparison extends Model
{
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function subCriteria1()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_criteria_id_1');
    }

    public function subCriteria2()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_criteria_id_2');
    }
}
