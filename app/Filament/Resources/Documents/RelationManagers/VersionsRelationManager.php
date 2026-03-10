<?php

namespace App\Filament\Resources\Documents\RelationManagers;

use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;

class VersionsRelationManager extends RelationManager
{
    protected static string $relationship = 'versions';

    protected static ?string $title = 'Riwayat Revisi & Arsip File';

    /**
     * Kita buat Form kosong karena riwayat tidak boleh diubah manual.
     */
    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('version_number')
            // Mengurutkan dari versi terbaru ke terlama
            ->defaultSort('version_number', 'desc')
            ->columns([
                TextColumn::make('version_number')
                    ->label('Versi Ke-')
                    ->badge()
                    ->color('gray')
                    ->prefix('v'),

                TextColumn::make('user.name')
                    ->label('Pengunggah Versi Ini')
                    ->icon('heroicon-m-user')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Waktu Pengarsipan')
                    ->dateTime('d M Y, H:i')
                    ->description(fn($record) => $record->created_at->diffForHumans())
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Keterangan Riwayat')
                    ->wrap()
                    ->placeholder('Tidak ada catatan.'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Menghapus CreateAction agar arsip hanya dibuat secara otomatis oleh sistem
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Unduh File Ini')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn($record) => Storage::url($record->file_path))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
