<?php

namespace App\Filament\Resources\Documents;

use App\Filament\Resources\Documents\Pages\CreateDocument;
use App\Filament\Resources\Documents\Pages\EditDocument;
use App\Filament\Resources\Documents\Pages\ListDocuments;
use App\Filament\Resources\Documents\RelationManagers\VersionsRelationManager;
use App\Filament\Resources\Documents\Schemas\DocumentForm;
use App\Filament\Resources\Documents\Tables\DocumentsTable;
use App\Models\Document;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    // Mengganti ikon menjadi bentuk dokumen agar lebih representatif
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    
    // Memberikan nama menu yang lebih jelas di Sidebar (opsional tapi disarankan)
    protected static ?string $navigationLabel = 'Daftar Dokumen';
    protected static ?string $pluralModelLabel = 'Dokumen Akademik';

    // PERBAIKAN: Kolom di tabel documents kita adalah 'title', bukan 'name'
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        // Memanggil konfigurasi form dari Canvas sebelumnya
        return DocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // Memanggil konfigurasi tabel yang sudah difilter berdasarkan hak akses
        return DocumentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
           VersionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocuments::route('/'),
            'create' => CreateDocument::route('/create'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }
}