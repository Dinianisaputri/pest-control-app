<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiPerbaikan extends Model
{
    protected $fillable = ['entry_id', 'catatan', 'gambar'];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}