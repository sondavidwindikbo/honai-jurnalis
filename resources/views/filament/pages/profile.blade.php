<x-filament-panels::page>

    <x-filament-panels::form wire:submit="saveProfile">
        {{ $this->profileForm }}
        <x-filament::button type="submit">
            Simpan Profil
        </x-filament::button>
    </x-filament-panels::form>

    <div style="margin-top: 32px;">
        <x-filament-panels::form wire:submit="savePassword">
            {{ $this->passwordForm }}
            <x-filament::button type="submit" color="warning">
                Ubah Password
            </x-filament::button>
        </x-filament-panels::form>
    </div>

</x-filament-panels::page>
