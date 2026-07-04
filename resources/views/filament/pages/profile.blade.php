<x-filament-panels::page>

    {{-- ===== FORM PROFIL ===== --}}
    <x-filament-panels::form wire:submit="saveProfile">
        {{ $this->profileForm }}
        <div style="margin-top:8px;">
            <x-filament::button type="submit" icon="heroicon-o-check">
                Simpan Profil
            </x-filament::button>
        </div>
    </x-filament-panels::form>

    {{-- ===== DIVIDER ===== --}}
    <div style="border-top:1px solid #e5e7eb;margin:32px 0;"></div>

    {{-- ===== FORM GANTI PASSWORD ===== --}}
    <x-filament-panels::form wire:submit="savePassword">
        {{ $this->passwordForm }}
        <div style="margin-top:8px;">
            <x-filament::button type="submit" color="warning"
                                icon="heroicon-o-lock-closed">
                Ubah Password
            </x-filament::button>
        </div>
    </x-filament-panels::form>

</x-filament-panels::page>
