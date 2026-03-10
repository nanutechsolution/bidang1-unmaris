<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    /**
     * Relasi ke Dokumen (Satu unit bisa memiliki banyak dokumen)
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relasi ke User (Satu unit/prodi bisa memiliki banyak user/dosen/staf)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}