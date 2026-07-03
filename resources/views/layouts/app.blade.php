<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Honai Jurnalis Kampung' }}</title>
    <meta name="description" content="Media warga yang meliput isu-isu lokal Papua dari perspektif masyarakat akar rumput.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,600;1,8..60,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-hjk.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="honai-body">

   {{-- Loading Screen --}}
<div id="page-loader"
     style="position:fixed;inset:0;z-index:9999;background:#1A1209;
            display:flex;flex-direction:column;align-items:center;
            justify-content:center;gap:16px;">

    {{-- Logo HJK --}}
    <div style="position:relative;">
        <img src="{{ asset('images/logo-hjk.png') }}"
             alt="Honai Jurnalis Kampung"
             id="loader-logo"
             style="width:90px;height:90px;object-fit:contain;
                    border-radius:50%;
                    animation:logoPulse 1s ease-in-out infinite alternate;">
    </div>

    {{-- Nama website --}}
    <div style="text-align:center;">
        <div style="font-family:'Playfair Display',Georgia,serif;
                    font-size:18px;font-weight:700;color:white;
                    letter-spacing:-0.01em;">
            Honai Jurnalis <span style="color:#E74C3C;">Kampung</span>
        </div>
        <div style="font-family:'JetBrains Mono',monospace;
                    font-size:9px;letter-spacing:0.15em;
                    color:rgba(255,255,255,0.35);margin-top:4px;
                    text-transform:uppercase;">
            Suara Tanah Papua
        </div>
    </div>

    {{-- Loading bar --}}
    <div style="width:120px;height:2px;background:rgba(255,255,255,0.1);
                border-radius:2px;overflow:hidden;">
        <div id="loader-bar"
             style="height:100%;width:0%;background:var(--red);
                    border-radius:2px;transition:width 0.3s ease;">
        </div>
    </div>

</div>

<style>
@keyframes logoPulse {
    0%   { transform: scale(1);    opacity: 0.9; }
    100% { transform: scale(1.06); opacity: 1;   }
}
</style>

<script>
(function () {
    const loader  = document.getElementById('page-loader');
    const bar     = document.getElementById('loader-bar');
    let progress  = 0;

    // Animasi loading bar naik bertahap
    const interval = setInterval(function () {
        progress += Math.random() * 25;
        if (progress > 90) progress = 90; // berhenti di 90, tunggu window.load
        bar.style.width = progress + '%';
    }, 120);

    window.addEventListener('load', function () {
        clearInterval(interval);

        // Selesaikan bar ke 100%
        bar.style.width = '100%';

        // Tunggu sebentar lalu fade out
        setTimeout(function () {
            loader.style.transition = 'opacity 0.35s ease';
            loader.style.opacity    = '0';
            setTimeout(function () {
                loader.style.display = 'none';
            }, 350);
        }, 300);
    });
})();
</script>

<script>
    window.addEventListener('load', () => {
        const loader = document.getElementById('page-loader');
        loader.style.opacity = '0';
        setTimeout(() => loader.style.display = 'none', 300);
    });
</script>

    <x-honai.masthead />
{{-- Nav hanya tampil di desktop --}}
<div class="desktop-nav-wrapper">
    <x-honai.nav />
</div>

    <main>
        {{ $slot }}
    </main>

    <x-honai.footer />

    @livewireScripts
    {{-- Scroll to top --}}
    <button id="scrollTopBtn"
        onclick="window.scrollTo({top:0,behavior:'smooth'})"
        style="display:none;position:fixed;bottom:28px;right:28px;z-index:50;
            background:var(--red);color:white;border:none;width:42px;height:42px;
            cursor:pointer;font-size:18px;box-shadow:0 4px 12px rgba(0,0,0,0.2);">
        &#8679;
    </button>
    <script>
        const btn = document.getElementById('scrollTopBtn');
        window.addEventListener('scroll', () => {
            btn.style.display = window.scrollY > 300 ? 'block' : 'none';
        });
    </script>
</body>
</html>
