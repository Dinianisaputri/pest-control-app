<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = [
        'trap_id',
        'tanggal',
        'tindakan',
        'aktivitas',
        'hasil',];
public function trap()
    {
        return $this->belongsTo(Trap::class);
    }

    public function rekomendasi()
    {
        return $this->hasOne(RekomendasiPerbaikan::class);
    }
}
