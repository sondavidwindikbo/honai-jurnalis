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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="honai-body">

    <x-honai.masthead />
    <x-honai.nav />

    <main>
        {{ $slot }}
    </main>

    <x-honai.footer />

    @livewireScripts
</body>
</html>
