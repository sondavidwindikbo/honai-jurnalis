<div class="content">

    {{-- Breadcrumb --}}
    <div style="font-family:'JetBrains Mono',monospace;font-size:11px;color:var(--muted);margin-bottom:20px;">
        <a href="{{ route('home') }}" style="color:var(--muted);text-decoration:none;">Beranda</a>
        &rsaquo;
        <a href="{{ route('category.show', $article->category->slug) }}" style="color:var(--muted);text-decoration:none;">{{ $article->category->name }}</a>
        &rsaquo;
        <span style="color:var(--ink);">{{ Str::limit($article->title, 50) }}</span>
    </div>

    <div class="main-sidebar">

        {{-- ===== KOLOM KIRI: ARTIKEL ===== --}}
        <div>

            {{-- Header artikel --}}
            <span class="category-tag">{{ $article->category->name }}</span>

            <h1 style="font-family:'Playfair Display',serif;font-size:36px;font-weight:700;
                        line-height:1.2;color:var(--ink);margin:12px 0 14px;">
                {{ $article->title }}
            </h1>

            @if($article->excerpt)
            <p style="font-size:18px;font-style:italic;font-weight:300;color:var(--ink2);
                       line-height:1.7;border-left:3px solid var(--red);padding-left:16px;
                       margin-bottom:20px;">
                {{ $article->excerpt }}
            </p>
            @endif

            <div style="font-family:'JetBrains Mono',monospace;font-size:11px;color:var(--muted);
                        padding:10px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);
                        margin-bottom:28px;display:flex;gap:16px;flex-wrap:wrap;">
                <span>Oleh <strong style="color:var(--ink);">{{ $article->user->name }}</strong></span>
                <span>&bull;</span>
                <span>{{ $article->published_at?->translatedFormat('l, j F Y') }}</span>
                <span>&bull;</span>
                <span>{{ $article->views }}x dibaca</span>
                @if($article->tags->isNotEmpty())
                <span>&bull;</span>
                <span>
                    @foreach($article->tags as $tag)
                        <span style="background:var(--paper2);border:1px solid var(--border2);
                                     padding:1px 8px;font-size:10px;margin-right:4px;">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </span>
                @endif
            </div>

            {{-- Foto sampul --}}
            @if($article->cover_image)
            <div style="margin-bottom:28px;">
                <img src="{{ asset('storage/' . $article->cover_image) }}"
                     alt="{{ $article->title }}"
                     style="width:100%;max-height:420px;object-fit:cover;">
            </div>
            @endif

            {{-- Isi artikel --}}
            <div style="font-size:16px;line-height:1.9;color:var(--ink2);">
                {!! $article->content !!}
            </div>

            {{-- Garis penutup artikel --}}
            <div style="border-top:3px double var(--border);margin:36px 0 28px;
                        text-align:center;font-family:'JetBrains Mono',monospace;
                        font-size:10px;color:var(--muted);padding-top:10px;letter-spacing:.1em;">
                — SELESAI —
            </div>

            {{-- Share --}}
            <div style="margin:20px 0 32px;padding:16px;background:var(--paper2);
                        border:1px solid var(--border);display:flex;align-items:center;
                        gap:12px;flex-wrap:wrap;">
                <span style="font-family:'JetBrains Mono',monospace;font-size:11px;
                            letter-spacing:.06em;color:var(--muted);">BAGIKAN:</span>

                @php $url = urlencode(request()->url()); $title = urlencode($article->title); @endphp

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                wire:click="share('facebook')"
                target="_blank"
                style="background:#1877F2;color:white;padding:7px 16px;font-family:'JetBrains Mono',monospace;
                        font-size:11px;text-decoration:none;letter-spacing:.04em;">
                    Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"
                wire:click="share('twitter')"
                target="_blank"
                style="background:#000;color:white;padding:7px 16px;font-family:'JetBrains Mono',monospace;
                        font-size:11px;text-decoration:none;letter-spacing:.04em;">
                    X / Twitter
                </a>
                <a href="https://wa.me/?text={{ $title }}%20{{ $url }}"
                wire:click="share('whatsapp')"
                target="_blank"
                style="background:#25D366;color:white;padding:7px 16px;font-family:'JetBrains Mono',monospace;
                        font-size:11px;text-decoration:none;letter-spacing:.04em;">
                    WhatsApp
                </a>

                <span style="margin-left:auto;font-family:'JetBrains Mono',monospace;font-size:11px;color:var(--muted);">
                    {{ $article->shares }} kali dibagikan
                </span>
            </div>

            {{-- ===== KOMENTAR ===== --}}
            <div id="komentar">
                <div class="section-header">
                    <span class="section-title">Komentar ({{ $comments->count() }})</span>
                </div>

                {{-- Daftar komentar --}}
                @forelse($comments as $comment)
                <div style="border-bottom:1px solid var(--border);padding:16px 0;">
                    <div style="font-family:'JetBrains Mono',monospace;font-size:11px;
                                color:var(--muted);margin-bottom:6px;">
                        <strong style="color:var(--ink);">{{ $comment->author_name }}</strong>
                        &bull;
                        {{ $comment->created_at->diffForHumans() }}
                    </div>
                    <p style="font-size:14px;line-height:1.7;color:var(--ink2);margin:0;">
                        {{ $comment->body }}
                    </p>
                </div>
                @empty
                <p style="color:var(--muted);font-size:13px;padding:16px 0;">
                    Belum ada komentar. Jadilah yang pertama berkomentar.
                </p>
                @endforelse

                {{-- Form komentar --}}
                <div style="margin-top:28px;background:var(--paper2);padding:24px;
                            border:1px solid var(--border2);">
                    <div style="font-family:'Playfair Display',serif;font-size:18px;
                                font-weight:700;margin-bottom:16px;color:var(--ink);">
                        Tulis Komentar
                    </div>

                    @if($submitted)
                        <div style="background:#ECFDF5;border:1px solid #6EE7B7;padding:14px 18px;
                                    font-size:13px;color:#065F46;">
                            Komentar berhasil dikirim dan sedang menunggu persetujuan redaksi.
                        </div>
                    @else

                        @if(!auth()->check())
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div>
                                <label style="font-family:'JetBrains Mono',monospace;font-size:10px;
                                              letter-spacing:.06em;display:block;margin-bottom:5px;color:var(--muted);">
                                    NAMA *
                                </label>
                                <input wire:model="guestName" type="text" placeholder="Nama kamu"
                                       style="width:100%;padding:9px 12px;border:1px solid var(--border2);
                                              background:white;font-family:'Source Serif 4',serif;
                                              font-size:14px;outline:none;box-sizing:border-box;">
                                @error('guestName')
                                    <span style="color:var(--red);font-size:11px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label style="font-family:'JetBrains Mono',monospace;font-size:10px;
                                              letter-spacing:.06em;display:block;margin-bottom:5px;color:var(--muted);">
                                    EMAIL (OPSIONAL)
                                </label>
                                <input wire:model="guestEmail" type="email" placeholder="email@contoh.com"
                                       style="width:100%;padding:9px 12px;border:1px solid var(--border2);
                                              background:white;font-family:'Source Serif 4',serif;
                                              font-size:14px;outline:none;box-sizing:border-box;">
                                @error('guestEmail')
                                    <span style="color:var(--red);font-size:11px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div style="margin-bottom:14px;">
                            <label style="font-family:'JetBrains Mono',monospace;font-size:10px;
                                          letter-spacing:.06em;display:block;margin-bottom:5px;color:var(--muted);">
                                KOMENTAR *
                            </label>
                            <textarea wire:model="body" rows="4" placeholder="Tulis komentar kamu..."
                                      style="width:100%;padding:9px 12px;border:1px solid var(--border2);
                                             background:white;font-family:'Source Serif 4',serif;font-size:14px;
                                             outline:none;resize:vertical;box-sizing:border-box;">
                            </textarea>
                            @error('body')
                                <span style="color:var(--red);font-size:11px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <button wire:click="submitComment" wire:loading.attr="disabled"
                                style="background:var(--red);color:white;border:none;
                                       padding:10px 24px;font-family:'JetBrains Mono',monospace;
                                       font-size:11px;letter-spacing:.08em;cursor:pointer;
                                       text-transform:uppercase;">
                            <span wire:loading.remove>Kirim Komentar</span>
                            <span wire:loading>Mengirim...</span>
                        </button>

                    @endif
                </div>
            </div>

        </div>

        {{-- ===== SIDEBAR KANAN ===== --}}
        <div class="sidebar">

            {{-- Info Penulis --}}
            <div class="sidebar-widget">
                <div class="widget-title">Tentang Penulis</div>
                <div class="widget-body">
                    <div style="font-family:'Playfair Display',serif;font-size:15px;
                                font-weight:700;margin-bottom:4px;">
                        {{ $article->user->name }}
                    </div>
                    @if($article->user->profile?->bio)
                    <p style="font-size:12px;color:var(--muted);line-height:1.6;margin:0 0 8px;">
                        {{ Str::limit($article->user->profile->bio, 120) }}
                    </p>
                    @endif
                    <div style="font-family:'JetBrains Mono',monospace;font-size:10px;color:var(--muted);">
                        {{ $article->user->articles()->published()->count() }} artikel diterbitkan
                    </div>
                </div>
            </div>

            {{-- Artikel Terkait --}}
            @if($related->isNotEmpty())
            <div class="sidebar-widget">
                <div class="widget-title">Artikel Terkait</div>
                <div class="widget-body" style="padding:0;">
                    @foreach($related as $r)
                    <a href="{{ route('article.show', $r->slug) }}"
                       style="display:block;padding:14px;border-bottom:1px solid var(--border);
                              text-decoration:none;color:inherit;">
                        <span class="category-tag outline" style="font-size:9px;padding:2px 6px;">
                            {{ $r->category->name }}
                        </span>
                        <div class="story-title" style="font-size:14px;margin-top:6px;">
                            {{ $r->title }}
                        </div>
                        <div class="byline" style="margin-top:4px;">
                            {{ $r->published_at?->diffForHumans() }}
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
