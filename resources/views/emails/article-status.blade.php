<x-mail::message>

{{-- Header --}}
<div style="text-align:center;margin-bottom:24px;">
    <img src="{{ asset('images/logo-hjk.png') }}"
         alt="Honai Jurnalis Kampung"
         style="height:60px;border-radius:50%;">
    <h2 style="font-family:Georgia,serif;color:#1A1209;margin-top:8px;">
        Honai Jurnalis Kampung
    </h2>
</div>

{{-- Konten berdasarkan tipe --}}
@if($type === 'submitted')
# 📨 Artikel Baru Menunggu Review

Halo **{{ $article->user->name }}**,

Artikel kamu telah berhasil dikirim dan sedang menunggu proses review oleh editor.

**Judul:** {{ $article->title }}
**Kategori:** {{ $article->category->name }}
**Dikirim:** {{ now()->translatedFormat('l, j F Y H:i') }}

Kami akan memberitahu kamu setelah artikel selesai direview.

<x-mail::button :url="url('/penulis/articles/' . $article->id . '/edit')" color="success">
    Lihat Artikel
</x-mail::button>

@elseif($type === 'published')
# 🎉 Artikel Kamu Berhasil Diterbitkan!

Halo **{{ $article->user->name }}**,

Selamat! Artikel kamu telah disetujui dan kini sudah tayang di website Honai Jurnalis Kampung.

**Judul:** {{ $article->title }}
**Kategori:** {{ $article->category->name }}
**Diterbitkan:** {{ $article->published_at?->translatedFormat('l, j F Y H:i') }}

Terima kasih atas kontribusimu untuk jurnalisme warga Papua!

<x-mail::button :url="route('article.show', $article->slug)" color="success">
    Baca Artikel di Website
</x-mail::button>

@elseif($type === 'rejected')
# 📝 Artikel Perlu Direvisi

Halo **{{ $article->user->name }}**,

Artikel kamu telah direview dan perlu diperbaiki sebelum dapat diterbitkan.

**Judul:** {{ $article->title }}
**Kategori:** {{ $article->category->name }}

Silakan buka artikel dan lakukan perbaikan sesuai catatan dari editor, lalu kirim ulang untuk direview kembali.

<x-mail::button :url="url('/penulis/articles/' . $article->id . '/edit')" color="danger">
    Perbaiki Artikel
</x-mail::button>

@elseif($type === 'revision')
# 🔄 Revisi Artikel Dikirim Ulang

Halo Editor,

Penulis **{{ $article->user->name }}** telah mengirim ulang revisi artikel yang sebelumnya dikembalikan.

**Judul:** {{ $article->title }}
**Kategori:** {{ $article->category->name }}
**Dikirim ulang:** {{ now()->translatedFormat('l, j F Y H:i') }}

<x-mail::button :url="url('/editor/articles/' . $article->id . '/edit')" color="warning">
    Review Revisi
</x-mail::button>

@endif

---

Salam,<br>
**Redaksi Honai Jurnalis Kampung**<br>
*Suara Tanah Papua · Berita Nyata dari Akar Rumput*

<x-mail::subcopy>
Email ini dikirim otomatis oleh sistem. Jangan balas email ini.
</x-mail::subcopy>

</x-mail::message>
