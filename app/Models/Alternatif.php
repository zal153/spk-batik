<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    protected $guarded = [];

    public function bahan()
    {
        return $this->belongsTo(SubKriteria::class, 'bahan_sub_id');
    }

    public function motif()
    {
        return $this->belongsTo(SubKriteria::class, 'motif_sub_id');
    }

    public function hargaSub()
    {
        return $this->belongsTo(SubKriteria::class, 'harga_sub_id');
    }

    public function warna()
    {
        return $this->belongsTo(SubKriteria::class, 'warna_sub_id');
    }

    public function fungsi()
    {
        return $this->belongsTo(SubKriteria::class, 'fungsi_sub_id');
    }
}
