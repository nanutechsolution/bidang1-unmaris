<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use UnitEnum;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageSettings extends Page
{
    // Properti navigasi untuk memunculkan di sidebar
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Pengaturan Sistem';

    protected static ?string $title = 'Pengaturan Sistem';

    // protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    // Urutan menu agar berada di posisi yang diinginkan
    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.manage-settings';

    /**
     * HAK AKSES (CRITICAL)
     * Memastikan hanya Super Admin atau Rektorat yang bisa melihat menu ini.
     * Jika metode ini tidak ada, menu mungkin tersembunyi jika Anda menggunakan plugin permission.
     */
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && in_array($user->role, ['super_admin', 'rektorat']);
    }

    public ?array $data = [];

    public function mount(): void
    {
        // Mengisi form dengan data dari database
        $this->form->fill([
            'pimpinan_nidn' => Setting::get('pimpinan_nidn', []),
            'app_name' => Setting::get('app_name', 'SIMA UNMARIS'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Konfigurasi Hak Akses')
                    ->description('Kelola daftar NIDN yang otomatis memiliki akses Rektorat/Pimpinan.')
                    ->schema([
                        TagsInput::make('pimpinan_nidn')
                            ->label('Daftar NIDN Pimpinan')
                            ->placeholder('Tambah NIDN...')
                            ->helperText('User dengan NIDN ini akan otomatis memiliki role Rektorat saat login via SIAKAD.'),
                    ]),
                
                Section::make('Identitas Aplikasi')
                    ->schema([
                        TextInput::make('app_name')
                            ->label('Nama Aplikasi')
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->action('submit'),
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        // Simpan NIDN Pimpinan ke database
        Setting::updateOrCreate(
            ['key' => 'pimpinan_nidn'],
            [
                'value' => json_encode($data['pimpinan_nidn']),
                'label' => 'Daftar NIDN Pimpinan',
                'type' => 'array'
            ]
        );

        // Simpan Nama Aplikasi
        Setting::updateOrCreate(
            ['key' => 'app_name'],
            ['value' => $data['app_name'], 'label' => 'Nama Aplikasi', 'type' => 'text']
        );

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->success()
            ->send();
    }
}