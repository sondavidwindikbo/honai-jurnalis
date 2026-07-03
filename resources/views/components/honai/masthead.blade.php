<div class="masthead" x-data="{ mobileMenuOpen: false, loginOpen: false }">

    {{-- TOP BAR --}}
    <div class="top-bar">
        <div class="breaking-ticker">
            <span class="breaking-label">Terkini</span>
            <span class="ticker-text">
                @php
                    $latestTitles = \App\Models\Article::published()
                        ->latest('published_at')->limit(5)->pluck('title')
                        ->join(' &nbsp;&bull;&nbsp; ');
                @endphp
                {!! $latestTitles ?: 'Selamat datang di Honai Jurnalis Kampung' !!}
            </span>
        </div>
        <span style="color:rgba(255,255,255,0.5);font-size:10px;
                     white-space:nowrap;margin-left:16px;">
            {{ now()->translatedFormat('l, j F Y') }}
        </span>
    </div>

    {{-- BARIS 1: Brand --}}
    <div class="masthead-brand">
        <a href="{{ route('home') }}"
           style="text-decoration:none;display:flex;align-items:center;gap:14px;">
            @php $logoSetting = \App\Models\Setting::where('key','site_logo')->value('value'); @endphp
            @if($logoSetting)
                <img src="{{ asset('storage/' . $logoSetting) }}"
                     alt="Logo" class="masthead-logo">
            @else
                <img src="{{ asset('images/logo-hjk.png') }}"
                     alt="Logo" class="masthead-logo">
            @endif
            <div>
                <div class="site-title">
                    {{ \App\Models\Setting::where('key','site_name')->value('value') ?? 'Honai Jurnalis' }}
                    <span>Kampung</span>
                </div>
                <div class="site-tagline">
                    {{ \App\Models\Setting::where('key','site_tagline')->value('value') ?? 'Suara Tanah Papua · Berita Nyata dari Akar Rumput' }}
                </div>
            </div>
        </a>

        {{-- Login icon (desktop only) --}}
        <div class="desktop-login" style="position:relative;margin-left:auto;display:flex;align-items:center;gap:12px;">

            {{-- Search desktop --}}
            <form action="{{ route('search') }}" method="GET" class="search-box desktop-search">
                <span class="search-icon">&#9906;</span>
                <input type="text" name="q" placeholder="Cari berita..." value="{{ request('q') }}" />
            </form>

            {{-- Login dropdown --}}
            <button @click="loginOpen = !loginOpen"
                    @click.outside="loginOpen = false"
                    style="background:transparent;border:none;cursor:pointer;
                           padding:6px 4px;display:flex;flex-direction:column;
                           align-items:center;gap:3px;color:rgba(255,255,255,0.85);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span style="font-family:'JetBrains Mono',monospace;
                             font-size:9px;letter-spacing:.06em;"></span>
            </button>

            {{-- Dropdown --}}
            <div x-show="loginOpen"
                 x-transition
                 @click.outside="loginOpen = false"
                 style="display:none;position:absolute;right:0;top:calc(100% + 8px);
                        background:white;min-width:200px;z-index:999;
                        box-shadow:0 10px 30px rgba(0,0,0,0.2);
                        border-top:3px solid #C0392B;">
                <div style="padding:10px 16px 8px;font-family:'JetBrains Mono',monospace;
                            font-size:9px;letter-spacing:.12em;color:#9ca3af;
                            text-transform:uppercase;border-bottom:1px solid #f3f4f6;">
                    Masuk sebagai
                </div>
                @foreach([
                    ['url'=>'/admin/login','label'=>'Admin','desc'=>'Kelola sistem','color'=>'#C0392B','bg'=>'#FEE2E2','hover'=>'#fef2f2'],
                    ['url'=>'/editor/login','label'=>'Editor','desc'=>'Review artikel','color'=>'#B7860B','bg'=>'#FEF3C7','hover'=>'#fffbeb'],
                    ['url'=>'/penulis/login','label'=>'Penulis','desc'=>'Tulis artikel','color'=>'#27AE60','bg'=>'#DCFCE7','hover'=>'#f0fdf4'],
                ] as $item)
                <a href="{{ url($item['url']) }}"
                   style="display:flex;align-items:center;gap:12px;padding:13px 16px;
                          text-decoration:none;color:#1A1209;
                          border-bottom:1px solid #f3f4f6;"
                   onmouseover="this.style.background='{{ $item['hover'] }}'"
                   onmouseout="this.style.background='transparent'">
                    <div style="width:32px;height:32px;border-radius:50%;
                                background:{{ $item['bg'] }};display:flex;
                                align-items:center;justify-content:center;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="{{ $item['color'] }}" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:13px;">{{ $item['label'] }}</div>
                        <div style="font-size:11px;color:#9ca3af;">{{ $item['desc'] }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- BARIS 2 MOBILE: Search full + Hamburger --}}
    <div class="mobile-searchbar">
        <form action="{{ route('search') }}" method="GET"
              style="flex:1;display:flex;align-items:center;
                     background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);
                     padding:10px 14px;gap:8px;">
            <span style="color:rgba(255,255,255,0.5);font-size:15px;">&#9906;</span>
            <input type="text" name="q" placeholder="Cari berita..."
                   value="{{ request('q') }}"
                   style="background:transparent;border:none;outline:none;
                          color:white;font-family:'Source Serif 4',serif;
                          font-size:14px;width:100%;">
        </form>

        {{-- Hamburger --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen"
                style="background:transparent;border:none;cursor:pointer;
                       padding:10px 14px;color:white;flex-shrink:0;">
            <svg x-show="!mobileMenuOpen" width="22" height="22" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.2">
                <line x1="3" y1="6" x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg x-show="mobileMenuOpen" width="22" height="22" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.2"
                 style="display:none;">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    {{-- MOBILE SIDEBAR DRAWER --}}
    {{-- Overlay gelap --}}
    <div x-show="mobileMenuOpen"
         @click="mobileMenuOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:998;">
    </div>

    {{-- Sidebar panel --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 -translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 -translate-x-full"
         style="display:none;position:fixed;top:0;left:0;bottom:0;width:280px;
                background:#1A1209;z-index:999;overflow-y:auto;
                box-shadow:4px 0 20px rgba(0,0,0,0.4);">

        {{-- Header sidebar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.1);
                    background:#2C2418;">
            <span style="font-family:'JetBrains Mono',monospace;font-size:11px;
                         letter-spacing:.1em;color:rgba(255,255,255,0.6);text-transform:uppercase;">
                Menu
            </span>
            <button @click="mobileMenuOpen = false"
                    style="background:transparent;border:none;color:rgba(255,255,255,0.6);
                           cursor:pointer;padding:4px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Navigasi --}}
        <div style="padding:8px 0;border-bottom:2px solid rgba(255,255,255,0.08);">
            <a href="{{ route('home') }}"
               style="display:flex;align-items:center;gap:14px;padding:14px 20px;
                      text-decoration:none;color:rgba(255,255,255,0.85);font-size:14px;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Beranda
            </a>
            @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
            <a href="{{ route('category.show', $cat->slug) }}"
               style="display:flex;align-items:center;gap:14px;padding:14px 20px;
                      text-decoration:none;color:rgba(255,255,255,0.75);font-size:14px;
                      border-top:1px solid rgba(255,255,255,0.05);">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        {{-- Masuk sebagai --}}
        <div style="padding:8px 0;border-bottom:2px solid rgba(255,255,255,0.08);">
            <div style="padding:12px 20px 6px;font-family:'JetBrains Mono',monospace;
                        font-size:9px;letter-spacing:.14em;color:rgba(255,255,255,0.35);
                        text-transform:uppercase;">
                Masuk sebagai
            </div>
            @foreach([
                ['url'=>'/admin/login','label'=>'Admin','desc'=>'Kelola sistem','color'=>'#E57373','bg'=>'rgba(192,57,43,0.15)'],
                ['url'=>'/editor/login','label'=>'Editor','desc'=>'Review artikel','color'=>'#FFB74D','bg'=>'rgba(183,134,11,0.15)'],
                ['url'=>'/penulis/login','label'=>'Penulis','desc'=>'Tulis artikel','color'=>'#66BB6A','bg'=>'rgba(39,174,96,0.15)'],
            ] as $item)
            <a href="{{ url($item['url']) }}"
               style="display:flex;align-items:center;justify-content:space-between;
                      padding:13px 20px;text-decoration:none;
                      border-top:1px solid rgba(255,255,255,0.05);"
               onmouseover="this.style.background='rgba(255,255,255,0.05)'"
               onmouseout="this.style.background='transparent'">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:{{ $item['bg'] }};display:flex;
                                align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="{{ $item['color'] }}" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div>
                        <div style="color:white;font-size:14px;font-weight:600;">
                            {{ $item['label'] }}
                        </div>
                        <div style="color:rgba(255,255,255,0.4);font-size:11px;margin-top:1px;">
                            {{ $item['desc'] }}
                        </div>
                    </div>
                </div>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="rgba(255,255,255,0.3)" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
            @endforeach
        </div>

        {{-- Info --}}
        <div style="padding:12px 20px;">
            <a href="#" style="display:block;color:rgba(255,255,255,0.45);
                               font-size:13px;padding:8px 0;text-decoration:none;">
                Tentang Kami
            </a>
            <a href="#" style="display:block;color:rgba(255,255,255,0.45);
                               font-size:13px;padding:8px 0;text-decoration:none;
                               border-top:1px solid rgba(255,255,255,0.05);">
                Kontak
            </a>
        </div>

    </div>

</div>
