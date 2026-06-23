<div class="content">

    <div class="edition-line">
        <span class="date">{{ now()->translatedFormat('l, j F Y') }}</span>
        <span class="dot">&bull;</span>
        <span>Edisi Digital</span>
        <span class="dot">&bull;</span>
        <span>{{ \App\Models\Article::published()->count() }} Artikel Diterbitkan</span>
    </div>

    {{-- ===== HERO GRID ===== --}}
    @if($heroMain)
    <div class="hero-grid">
        <a href="{{ route('article.show', $heroMain->slug) }}" class="hero-main">
            <span class="category-tag">{{ $heroMain->category->name }}</span>
            <div class="hero-image">
                @if($heroMain->cover_image)
                    <img src="{{ asset('storage/' . $heroMain->cover_image) }}" alt="{{ $heroMain->title }}">
                @else
                    <div class="hero-image-pattern"></div>
                    <span class="hero-image-label">Honai Jurnalis Kampung</span>
                @endif
            </div>
            <h1 class="hero-title">{{ $heroMain->title }}</h1>
            <p class="hero-deck">{{ $heroMain->excerpt }}</p>
            <div class="byline">
                Oleh <strong>{{ $heroMain->user->name }}</strong> &bull;
                {{ $heroMain->published_at?->translatedFormat('j F Y') }} &bull;
                {{ $heroMain->views }}x dibaca
            </div>
        </a>

        @foreach($heroSide as $article)
        <a href="{{ route('article.show', $article->slug) }}" class="hero-side">
            <span class="category-tag {{ $loop->first ? 'gold' : 'dark' }}">{{ $article->category->name }}</span>
            <div class="side-image {{ $loop->first ? 'img-papua1' : 'img-papua2' }}">
                @if($article->cover_image)
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                @endif
            </div>
            <h3 class="story-title">{{ $article->title }}</h3>
            <div class="byline">{{ $article->user->name }} &bull; {{ $article->published_at?->diffForHumans() }}</div>
        </a>
        @endforeach
    </div>
    @else
        <p style="padding:40px;text-align:center;color:var(--muted);">Belum ada artikel yang diterbitkan.</p>
    @endif

    {{-- ===== BERITA TERKINI ===== --}}
    @if($latestNews->isNotEmpty())
    <div class="section-header">
        <span class="section-title">Berita Terkini</span>
        <a href="{{ route('home') }}" class="section-more">Lihat Semua &rarr;</a>
    </div>
    <div class="news-grid-3">
        @foreach($latestNews as $article)
        <a href="{{ route('article.show', $article->slug) }}" class="news-card">
            <span class="category-tag outline">{{ $article->category->name }}</span>
            <div class="news-img img-papua3">
                @if($article->cover_image)
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                @endif
            </div>
            <h3 class="story-title">{{ $article->title }}</h3>
            <p class="story-deck">{{ Str::limit($article->excerpt, 90) }}</p>
            <div class="byline">{{ $article->user->name }} &bull; {{ $article->published_at?->diffForHumans() }}</div>
        </a>
        @endforeach
    </div>
    @endif

    {{-- ===== STORY LIST + SIDEBAR ===== --}}
    <div class="main-sidebar">
        <div class="story-list">
            <div class="section-header">
                <span class="section-title">Liputan Mendalam</span>
            </div>
            @forelse($storyList as $article)
            <a href="{{ route('article.show', $article->slug) }}" class="story-row">
                <span class="story-row-num">{{ sprintf('%02d', $loop->iteration) }}</span>
                <div class="story-row-content">
                    <span class="category-tag outline" style="margin-bottom:6px;">{{ $article->category->name }}</span>
                    <h3 class="story-title">{{ $article->title }}</h3>
                    <p class="story-deck">{{ Str::limit($article->excerpt, 110) }}</p>
                    <div class="byline">{{ $article->user->name }} &bull; {{ $article->published_at?->diffForHumans() }}</div>
                </div>
                <div class="story-row-img img-papua4">
                    @if($article->cover_image)
                        <img src="{{ asset('storage/' . $article->cover_image) }}" alt="">
                    @endif
                </div>
            </a>
            @empty
                <p style="color:var(--muted);font-size:13px;padding:16px 0;">Belum ada artikel lain.</p>
            @endforelse
        </div>

        <div class="sidebar">
            {{-- TRENDING --}}
            <div class="sidebar-widget">
                <div class="widget-title">Berita Terpopuler</div>
                <div class="widget-body">
                    @forelse($trending as $article)
                    <a href="{{ route('article.show', $article->slug) }}" class="trending-item">
                        <span class="trending-num">{{ $loop->iteration }}</span>
                        <span>{{ $article->title }}</span>
                    </a>
                    @empty
                        <p style="color:var(--muted);font-size:12px;">Belum ada data trending.</p>
                    @endforelse
                </div>
            </div>

            {{-- TAGS --}}
            @if($tags->isNotEmpty())
            <div class="sidebar-widget">
                <div class="widget-title">Topik</div>
                <div class="widget-body">
                    <div class="tag-cloud">
                        @foreach($tags as $tag)
                            <a href="#" class="tag">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== OPINI STRIP ===== --}}
    @php
        $opinions = \App\Models\Article::published()
            ->whereHas('category', fn($q) => $q->where('slug', 'opini'))
            ->latest('published_at')
            ->take(3)
            ->get();
    @endphp
    @if($opinions->isNotEmpty())
    <div class="opinion-strip">
        <div class="section-header">
            <span class="section-title">Opini &amp; Suara Warga</span>
            <a href="#" class="section-more">Lihat Semua &rarr;</a>
        </div>
        <div class="opinion-grid">
            @foreach($opinions as $opinion)
            <a href="{{ route('article.show', $opinion->slug) }}" class="opinion-card" style="text-decoration:none;color:inherit;">
                <p class="opinion-quote">&ldquo;{{ Str::limit($opinion->excerpt, 100) }}&rdquo;</p>
                <div class="opinion-author">{{ $opinion->user->name }}</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
