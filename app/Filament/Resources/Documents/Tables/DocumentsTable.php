<?php

namespace App\Filament\Resources\Documents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // DI SINI TEMPAT UNTUK MEMFILTER DATA (PENGGANTI getEloquentQuery)
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                // Pastikan kolom 'role' dan 'unit_id' sudah ada di tabel users (Sesuai Langkah 12)
                // Jika super_admin atau rektorat, lihat semua
                if (isset($user->role) && in_array($user->role, ['super_admin', 'rektorat'])) {
                    return $query;
                }

                // Jika prodi, hanya lihat dokumen prodi miliknya
                if (isset($user->unit_id)) {
                    return $query->where('unit_id', $user->unit_id);
                }

                return $query;
            })
            ->columns([
                // Menggunakan relasi 'unit.name' agar tampil nama prodinya, bukan angka ID
                TextColumn::make('unit.name')
                    ->label('Unit / Prodi')
                    ->sortable()
                    ->searchable(),
                    
                // Menggunakan relasi 'documentCategory.name'
                TextColumn::make('documentCategory.name')
                    ->label('Kategori Dokumen')
                    ->sortable()
                    ->searchable(),
                    
                // User yang mengupload
                TextColumn::make('user.name')
                    ->label('Diunggah Oleh')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('title')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->wrap(),
                    
                TextColumn::make('status')
                    ->label('Status')
                    ->badge() // Membuat tampilan status jadi menarik dengan warna
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'info',
                        'revised' => 'warning',
                        'approved' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),
                    
                TextColumn::make('created_at')
                    ->label('Tanggal Unggah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                    
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Nanti kita bisa tambahkan filter Status di sini
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}