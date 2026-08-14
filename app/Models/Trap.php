<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trap extends Model
{
    protected $fillable = [
        'no_trap',
        'type_detector',
        'spesies_hama',
        'lokasi',];
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
