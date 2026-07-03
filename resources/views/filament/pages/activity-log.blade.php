<x-filament-panels::page>
    <div style="font-family:monospace;font-size:13px;">
        @foreach($this->getLogs() as $log)
        <div style="padding:10px 0;border-bottom:1px solid #eee;display:flex;gap:16px;">
            <span style="color:#888;white-space:nowrap;">
                {{ $log->created_at->format('d/m/Y H:i') }}
            </span>
            <span>
                <strong>{{ $log->causer?->name ?? 'Sistem' }}</strong>
                {{ $log->description }}
                @if($log->subject)
                    "<em>{{ $log->subject->title ?? '' }}</em>"
                @endif
            </span>
        </div>
        @endforeach
    </div>
</x-filament-panels::page>
