<?php

namespace App\Filament\Resources\DocumentCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DocumentCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->placeholder('Contoh: RPS, SK Mengajar, Borang Akreditasi')
                    ->required(),
                    
                Textarea::make('description')
                    ->label('Deskripsi / Keterangan')
                    ->placeholder('Opsional: Berikan penjelasan singkat tentang dokumen yang masuk kategori ini')
                    ->columnSpanFull(),
            ]);
    }
}