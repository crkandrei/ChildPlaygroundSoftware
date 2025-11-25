<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $metaTitle ?? 'Bongoland - Loc de Joacă Vaslui' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Bongoland este cel mai bun loc de joacă din Vaslui pentru copii.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'loc de joacă Vaslui, playground Vaslui' }}">
    
    @vite(['resources/css/app.css', 'resources/js/landing.tsx'])
</head>
<body>
    <div id="landing-root"></div>
</body>
</html>

