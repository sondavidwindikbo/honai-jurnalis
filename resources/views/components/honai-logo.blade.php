<div style="display:flex;align-items:center;gap:{{ $gap ?? '10px' }}">
    <svg width="{{ $size ?? '42' }}" height="{{ $size ?? '42' }}" viewBox="0 0 40 40">
        <circle cx="20" cy="20" r="19" fill="#8B5E3C" stroke="#5C3A1E" stroke-width="1.5"/>
        <path d="M20 6 L34 22 L30 22 L30 33 L10 33 L10 22 L6 22 Z" fill="#C0392B"/>
        <rect x="17" y="24" width="6" height="9" fill="#8B5E3C"/>
        <circle cx="20" cy="14" r="2.2" fill="#FAF6EE"/>
        <path d="M10 22 Q20 18 30 22" fill="none" stroke="#FAF6EE" stroke-width="0.8" opacity="0.4"/>
        <text x="20" y="38" text-anchor="middle"
              font-family="monospace" font-size="4.5" fill="#FAF6EE"
              letter-spacing="1">HONAI</text>
    </svg>
    @if(!($hideText ?? false))
    <div>
        <div style="font-family:Georgia,serif;font-weight:700;font-size:{{ $fontSize ?? '16px' }};
                    line-height:1.1;color:{{ $textColor ?? 'inherit' }}">
            Honai Jurnalis <span style="color:#C0392B">Kampung</span>
        </div>
        @if(!($hideTagline ?? false))
        <div style="font-size:9px;letter-spacing:0.1em;
                    color:{{ $taglineColor ?? '#888' }};margin-top:2px;
                    font-family:monospace;text-transform:uppercase">
            Suara Tanah Papua
        </div>
        @endif
    </div>
    @endif
</div>
