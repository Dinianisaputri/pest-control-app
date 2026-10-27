<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiApprovalHistory extends Model
{
    protected $fillable = [
        'rekomendasi_perbaikan_id',
        'user_id',
        'aksi',
        'status_sebelumnya',
        'status_sesudahnya',
        'catatan',
    ];

    public function rekomendasiPerbaikan(): BelongsTo
    {
        return $this->belongsTo(
            RekomendasiPerbaikan::class,
            'rekomendasi_perbaikan_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
