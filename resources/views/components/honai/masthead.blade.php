<div class="masthead">
    <div class="top-bar">
        <div class="breaking-ticker">
            <span class="breaking-label">Terkini</span>
            <span class="ticker-text">
                @if($breakingNews ?? false)
                    {{ $breakingNews }}
                @else
                    Selamat datang di Honai Jurnalis Kampung — media warga dari tanah Papua
                @endif
            </span>
        </div>
        <span style="color:rgba(255,255,255,0.5);font-size:10px;white-space:nowrap;margin-left:16px;">
            {{ now()->translatedFormat('l, j F Y') }}
        </span>
    </div>
    <div class="masthead-main">
        <a href="{{ route('home') }}" style="text-decoration:none;">
            <div class="site-title">Honai Jurnalis <span>Kampung</span></div>
            <div class="site-tagline">Suara Tanah Papua &bull; Berita Nyata dari Akar Rumput</div>
        </a>
        <form action="{{ route('search') }}" method="GET" class="search-box">
            <span class="search-icon">&#9906;</span>
            <input type="text" name="q" placeholder="Cari berita..." value="{{ request('q') }}" />
        </form>
    </div>
</div>
