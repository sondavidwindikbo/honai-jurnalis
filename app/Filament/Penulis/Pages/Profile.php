<?php

namespace App\Filament\Penulis\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static string  $view            = 'filament.pages.profile';

    public ?array $profileData  = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $user    = auth()->user();
        $profile = $user->profile;

        $this->profileForm->fill([
            'name'         => $user->name,
            'email'        => $user->email,
            'phone'        => $profile?->phone,
            'bio'          => $profile?->bio,
            'address'      => $profile?->address,
            'instagram'    => $profile?->instagram,
            'facebook'     => $profile?->facebook,
            'joined_honai' => $profile?->joined_honai?->format('Y-m-d'),
        ]);
    }

    protected function getForms(): array
    {
        return ['profileForm', 'passwordForm'];
    }

    public function profileForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(
                                table: 'users',
                                column: 'email',
                                ignorable: auth()->user()
                            ),
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor HP')
                            ->tel(),
                        Forms\Components\DatePicker::make('joined_honai')
                            ->label('Bergabung dengan Honai sejak')
                            ->displayFormat('d/m/Y'),
                    ])->columns(2),

                Forms\Components\Section::make('Bio')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->label('Tentang Saya')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('address')
                            ->label('Domisili'),
                    ]),

                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->prefix('@'),
                        Forms\Components\TextInput::make('facebook')
                            ->label('Facebook'),
                    ])->columns(2),
            ])
            ->statePath('profileData');
    }

    public function passwordForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ganti Password')
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Password Saat Ini')
                            ->password()
                            ->revealable()
                            ->required()
                            ->currentPassword(),

                        Forms\Components\TextInput::make('new_password')
                            ->label('Password Baru')
                            ->password()
                            ->revealable()
                            ->required()
                            ->rule(Password::min(8))
                            ->different('current_password')
                            ->helperText('Minimal 8 karakter'),

                        Forms\Components\TextInput::make('new_password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->revealable()
                            ->required()
                            ->same('new_password'),
                    ])->columns(3),
            ])
            ->statePath('passwordData');
    }

    public function saveProfile(): void
    {
        $data = $this->profileForm->getState();
        $user = auth()->user();

        // Update data user
        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        // Update atau buat profil
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone'        => $data['phone'] ?? null,
                'bio'          => $data['bio'] ?? null,
                'address'      => $data['address'] ?? null,
                'instagram'    => $data['instagram'] ?? null,
                'facebook'     => $data['facebook'] ?? null,
                'joined_honai' => $data['joined_honai'] ?? null,
            ]
        );

        Notification::make()
            ->title('Profil berhasil disimpan!')
            ->success()
            ->send();
    }

    public function savePassword(): void
    {
        $data = $this->passwordForm->getState();

        auth()->user()->update([
            'password' => Hash::make($data['new_password']),
        ]);

        // Reset form password setelah berhasil
        $this->passwordForm->fill([
            'current_password'          => '',
            'new_password'              => '',
            'new_password_confirmation' => '',
        ]);

        Notification::make()
            ->title('Password berhasil diubah!')
            ->body('Gunakan password baru kamu untuk login berikutnya.')
            ->success()
            ->send();
    }
}
