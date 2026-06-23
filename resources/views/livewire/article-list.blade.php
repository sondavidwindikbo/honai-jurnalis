<div class="content">

    {{-- ===== HEADER HALAMAN ===== --}}
    <div style="border-top:3px solid var(--ink);border-bottom:1px solid var(--border);
                padding:20px 0;margin-bottom:28px;">

        @if($category)
            {{-- Header Halaman Kategori --}}
            <div style="font-family:'JetBrains Mono',monospace;font-size:10px;
                        letter-spacing:.1em;color:var(--red);text-transform:uppercase;
                        margin-bottom:6px;">Kategori</div>
            <h1 style="font-family:'Playfair Display',serif;font-size:36px;
                       font-weight:700;color:var(--ink);margin:0 0 6px;">
                {{ $category->name }}
            </h1>
            @if($category->description)
            <p style="font-size:14px;color:var(--muted);margin:0;">{{ $category->description }}</p>
            @endif

        @elseif($search)
            {{-- Header Halaman Pencarian --}}
            <div style="font-family:'JetBrains Mono',monospace;font-size:10px;
                        letter-spacing:.1em;color:var(--muted);text-transform:uppercase;
                        margin-bottom:6px;">Hasil Pencarian</div>
            <h1 style="font-family:'Playfair Display',serif;font-size:30px;
                       font-weight:700;color:var(--ink);margin:0 0 4px;">
                &ldquo;{{ $search }}&rdquo;
            </h1>
            <p style="font-size:13px;color:var(--muted);margin:0;">
                {{ $totalResults }} artikel ditemukan
            </p>

        @else
            {{-- Header Semua Artikel --}}
            <h1 style="font-family:'Playfair Display',serif;font-size:36px;
                       font-weight:700;color:var(--ink);margin:0;">
                Semua Artikel
            </h1>
        @endif
    </div>

    <div class="main-sidebar">

        {{-- ===== KOLOM KIRI: DAFTAR ARTIKEL ===== --}}
        <div>

            {{-- Filter & Sort --}}
            <div style="display:flex;align-items:center;justify-content:space-between;
                        margin-bottom:20px;gap:12px;flex-wrap:wrap;">

                {{-- Search bar (tampil di semua halaman) --}}
                <div style="display:flex;align-items:center;gap:8px;background:white;
                            border:1px solid var(--border2);padding:8px 14px;flex:1;min-width:200px;">
                    <span style="color:var(--muted);font-size:13px;">&#9906;</span>
                    <input wire:model.live.debounce.400ms="search"
                           type="text"
                           placeholder="Cari artikel..."
                           value="{{ $search }}"
                           style="border:none;outline:none;font-family:'Source Serif 4',serif;
                                  font-size:13px;width:100%;background:transparent;color:var(--ink);">
                </div>

                {{-- Sort --}}
                <select wire:model.live="sortBy"
                        style="border:1px solid var(--border2);padding:8px 14px;
                               font-family:'JetBrains Mono',monospace;font-size:11px;
                               letter-spacing:.04em;background:white;outline:none;
                               color:var(--ink);cursor:pointer;">
                    <option value="latest">Terbaru</option>
                    <option value="popular">Terpopuler</option>
                    <option value="oldest">Terlama</option>
                </select>
            </div>

            {{-- Grid artikel --}}
            @if($articles->isNotEmpty())
                <div class="news-grid-3">
                    @foreach($articles as $article)
                    <a href="{{ route('article.show', $article->slug) }}" class="news-card">
                        <span class="category-tag outline">{{ $article->category->name }}</span>
                        <div class="news-img {{ ['img-papua1','img-papua2','img-papua3','img-papua4'][($loop->index) % 4] }}">
                            @if($article->cover_image)
                                <img src="{{ asset('storage/' . $article->cover_image) }}"
                                     alt="{{ $article->title }}">
                            @endif
                        </div>
                        <h3 class="story-title">{{ $article->title }}</h3>
                        <p class="story-deck">{{ Str::limit($article->excerpt, 90) }}</p>
                        <div class="byline">
                            {{ $article->user->name }}
                            &bull;
                            {{ $article->published_at?->diffForHumans() }}
                            &bull;
                            {{ $article->views }}x dibaca
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div style="margin-top:28px;padding-top:20px;border-top:1px solid var(--border);">
                    {{ $articles->links() }}
                </div>

            @else
                {{-- Empty state --}}
                <div style="text-align:center;padding:60px 20px;border:1px solid var(--border);">
                    <div style="font-family:'Playfair Display',serif;font-size:22px;
                                color:var(--ink);margin-bottom:8px;">
                        Tidak ada artikel ditemukan
                    </div>
                    <p style="font-size:13px;color:var(--muted);margin:0 0 20px;">
                        @if($search)
                            Coba kata kunci lain atau lihat semua artikel.
                        @else
                            Belum ada artikel di kategori ini.
                        @endif
                    </p>
                    <a href="{{ route('home') }}"
                       style="background:var(--red);color:white;padding:10px 24px;
                              font-family:'JetBrains Mono',monospace;font-size:11px;
                              letter-spacing:.08em;text-decoration:none;text-transform:uppercase;">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif

        </div>

        {{-- ===== SIDEBAR KANAN ===== --}}
        <div class="sidebar">

            {{-- Semua Kategori --}}
            <div class="sidebar-widget">
                <div class="widget-title">Semua Kategori</div>
                <div class="widget-body" style="padding:0;">
                    <a href="{{ route('home') }}"
                       class="trending-item"
                       style="padding:10px 14px;font-size:12px;display:flex;justify-content:space-between;">
                        <span>Semua Artikel</span>
                    </a>
                    @foreach($allCategories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}"
                       class="trending-item"
                       style="padding:10px 14px;font-size:12px;display:flex;justify-content:space-between;
                              {{ $category?->slug === $cat->slug ? 'background:var(--red-light);color:var(--red);font-weight:500;' : '' }}">
                        <span>{{ $cat->name }}</span>
                        <span style="font-family:'JetBrains Mono',monospace;font-size:10px;
                                     color:var(--muted);">{{ $cat->articles_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>
