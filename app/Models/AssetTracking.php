<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetTracking extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = ['id'];


    /**
     * Casting JSON dari database otomatis menjadi Array di PHP
     */
    protected function casts(): array
    {
        return [
            'previous_state' => 'array',
            'new_state'      => 'array',
        ];
    }

    /**
     * Relasi: Tracking ini milik Aset yang mana
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * Relasi: Siapa user yang melakukan perubahan
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}