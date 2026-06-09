<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Fullbay Interview Demo'))</title>

    @vite([
        'resources/js/app.js',
        'resources/scss/app.scss',
    ])

    @livewireStyles
</head>
<body class="@yield('body_class', 'app-shell')">
<main class="page-shell">
    @yield('content')
</main>

@livewireScripts
</body>
</html>
