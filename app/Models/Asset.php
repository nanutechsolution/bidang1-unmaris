<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use SoftDeletes, HasFactory, HasUuids;

    protected $guarded = ['id'];

    /**
     * Casting tipe data secara strict
     */
    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'price'         => 'decimal:2',
        ];
    }

    /**
     * Relasi: Aset milik satu Kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    /**
     * Relasi: Aset berada di satu Lokasi
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Relasi: Aset memiliki banyak riwayat Tracking
     */
    public function trackings(): HasMany
    {
        return $this->hasMany(AssetTracking::class, 'asset_id');
    }
}
