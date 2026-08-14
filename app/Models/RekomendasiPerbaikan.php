<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiPerbaikan extends Model
{
   protected $fillable = ['entry_id', 'rekomendasi_catatan', 'rekomendasi_gambar', 'perbaikan_catatan', 'perbaikan_gambar'];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}