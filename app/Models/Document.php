<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    // Relasi ke tabel versi
    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class)->orderBy('version_number', 'desc');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function documentCategory(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot Method: Logika otomatis untuk Versioning
     */
    protected static function booted()
    {
        // Saat dokumen akan di-update
        static::updating(function ($document) {
            // Jika kolom file_path berubah (ada upload baru)
            if ($document->isDirty('file_path')) {
                // Simpan file lama ke tabel riwayat (versions)
                $document->versions()->create([
                    'user_id' => auth()->id() ?? $document->user_id,
                    'file_path' => $document->getOriginal('file_path'),
                    'version_number' => $document->versions()->count() + 1,
                    'description' => 'Arsip versi sebelumnya sebelum diperbarui pada ' . now()->format('d M Y H:i'),
                ]);
            }
        });
    }


    /**
     * Helper untuk mencatat aktivitas audit secara manual
     */
    public function logActivity(string $activity): void
    {
        $this->auditLogs()->create([
            'user_id' => auth()->id(),
            'activity' => $activity,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
