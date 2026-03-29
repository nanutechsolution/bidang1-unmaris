<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetCategory extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    // Proteksi mass assignment (hanya 'id' yang tidak boleh diisi manual)
    protected $guarded = ['id'];

    /**
     * Relasi: Satu Kategori memiliki banyak Aset
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'category_id');
    }
}