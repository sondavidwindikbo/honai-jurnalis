<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    {{-- Divider --}}
    <div style="display:flex;align-items:center;gap:12px;margin-top:8px;">
        <div style="flex:1;height:1px;background:#e5e7eb;"></div>
        <span style="font-size:12px;color:#9ca3af;">atau</span>
        <div style="flex:1;height:1px;background:#e5e7eb;"></div>
    </div>

    {{-- Tombol kembali ke beranda --}}
    <div style="text-align:center;margin-top:4px;">
        <a href="{{ url('/') }}"
           style="display:inline-flex;align-items:center;gap:6px;
                  color:#C0392B;text-decoration:none;font-size:14px;font-weight:500;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</x-filament-panels::page.simple>
