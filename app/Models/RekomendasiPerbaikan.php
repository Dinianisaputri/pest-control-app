<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekomendasiPerbaikan extends Model
{
   protected $fillable = ['entry_id', 'rekomendasi_catatan', 'rekomendasi_gambar', 'perbaikan_catatan', 'perbaikan_gambar','status_persetujuan','approved_by','catatan_admin','diputuskan_pada'];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
    public function approver()
{
    return $this->belongsTo(User::class, 'approved_by');
}

public function approvalHistories()
{
    return $this->hasMany(
        RekomendasiApprovalHistory::class,
        'rekomendasi_perbaikan_id'
    )->latest();
}

}