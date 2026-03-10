<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen')
                    ->schema([
                        Select::make('unit_id')
                            ->relationship('unit', 'name')
                            ->label('Unit / Prodi')
                            ->default(fn () => auth()->user()->unit_id)
                            // Hanya pimpinan yang bisa mengubah unit asal dokumen
                            ->disabled(fn () => !in_array(auth()->user()->role, ['super_admin', 'rektorat']))
                            ->dehydrated() // Memastikan nilai tetap dikirim meskipun disabled
                            ->required(),
                            
                        Select::make('document_category_id')
                            ->relationship('documentCategory', 'name')
                            ->label('Kategori Dokumen')
                            ->required(),
                            
                        TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->required(),
                            
                        FileUpload::make('file_path')
                            ->label('Berkas Dokumen (PDF/Word)')
                            ->directory('dokumen-akademik')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            // FITUR UNTUK MELIHAT DOKUMEN:
                            ->openable() // Memunculkan tombol untuk membuka file di tab baru
                            ->downloadable() // Memunculkan tombol untuk mengunduh file
                            ->previewable(true) // Menampilkan preview jika tipe file didukung (seperti PDF)
                            ->required(),
                            
                        Textarea::make('description')
                            ->label('Keterangan dari Pengunggah')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Disposisi & Status (Khusus Pimpinan)')
                    ->schema([
                        // Memastikan pimpinan (Warek 1/Rektorat) bisa mengisi feedback
                        Textarea::make('feedback')
                            ->label('Catatan Revisi / Disposisi')
                            ->placeholder('Tuliskan instruksi revisi di sini...')
                            ->rows(3)
                            ->readonly(fn () => !in_array(auth()->user()->role, ['super_admin', 'rektorat']))
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Status Dokumen')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Dikumpulkan',
                                'revised' => 'Perlu Revisi',
                                'approved' => 'Disetujui',
                            ])
                            ->required()
                            ->default('draft')
                            // Mengaktifkan pilihan status hanya untuk pimpinan
                            ->disabled(fn () => !in_array(auth()->user()->role, ['super_admin', 'rektorat']))
                            ->dehydrated(), 
                    ])
                    ->description('Bagian ini digunakan oleh Warek 1 untuk memberikan verifikasi dan catatan revisi.'),

                Hidden::make('user_id')
                    ->default(fn () => auth()->id()),
            ]);
    }
}