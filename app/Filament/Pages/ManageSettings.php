<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $navigationGroup = 'Sistem';
    protected static string  $view            = 'filament.pages.manage-settings';

    public ?array $data = [];

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public function mount(): void
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Website')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Nama Website')
                            ->default('Honai Jurnalis Kampung'),
                        Forms\Components\TextInput::make('site_tagline')
                            ->label('Tagline')
                            ->default('Suara Tanah Papua'),
                        Forms\Components\FileUpload::make('site_logo')
                            ->label('Logo Website')
                            ->image()
                            ->directory('settings')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email Redaksi')
                            ->email(),
                        Forms\Components\TextInput::make('contact_whatsapp')
                            ->label('Nomor WhatsApp'),
                        Forms\Components\Textarea::make('contact_address')
                            ->label('Alamat Kantor')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('social_facebook')
                            ->label('Facebook URL')->url(),
                        Forms\Components\TextInput::make('social_instagram')
                            ->label('Instagram URL')->url(),
                        Forms\Components\TextInput::make('social_youtube')
                            ->label('YouTube URL')->url(),
                        Forms\Components\TextInput::make('social_twitter')
                            ->label('X (Twitter) URL')->url(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan!')
            ->success()
            ->send();
    }
}
