<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentCategory extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    /**
     * Relasi ke Dokumen (Satu kategori bisa memiliki banyak dokumen)
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}