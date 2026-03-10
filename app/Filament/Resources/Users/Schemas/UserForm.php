<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email / NIDN')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('role')
                    ->label('Hak Akses (Role)')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'rektorat' => 'Rektorat / Warek 1',
                        'prodi' => 'Admin Prodi / Dosen',
                    ])
                    ->required()
                    ->native(false),

                Select::make('unit_id')
                    ->label('Unit / Prodi Kerja')
                    ->relationship('unit', 'name')
                    ->placeholder('Pilih Unit Kerja')
                    ->searchable()
                    ->preload()
                    ->native(false),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    // Hanya wajib diisi saat membuat user baru
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Kosongkan jika tidak ingin mengubah password.'),
            ]);
    }
}