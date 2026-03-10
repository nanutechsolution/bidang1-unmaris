<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Unit / Prodi')
                    ->placeholder('Cth: Prodi S1 Keperawatan')
                    ->required(),
                    
                // Mengubah TextInput menjadi Select agar pengguna tidak salah ketik
                Select::make('type')
                    ->label('Tipe Unit')
                    ->options([
                        'rektorat' => 'Rektorat / Pimpinan',
                        'pusat' => 'Pusat / Lembaga',
                        'prodi' => 'Program Studi',
                    ])
                    ->required(),
            ]);
    }
}