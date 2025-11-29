<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $title ?? config('app.name', 'SeeBooks') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        @if (session('status'))
            <div class="alert alert-info mb-4">
                <span>{{ session('status') }}</span>
            </div>
        @endif

        {{-- konten halaman --}}
        @yield('content')
    </div>

</body>
</html>
