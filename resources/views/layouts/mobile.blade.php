<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $title ?? config('app.name', 'SeeBooks') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 flex flex-col">

    {{-- Top bar sederhana --}}
    <header class="w-full border-b border-base-300 bg-base-100">
        <div class="max-w-md mx-auto flex items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="font-semibold text-lg">
                SeeBooks
            </a>

            @auth
                <span class="text-xs text-base-content/70">
                    {{ Auth::user()->username ?? Auth::user()->name }}
                </span>
            @endauth
        </div>
    </header>

    {{-- Konten utama: mobile-first, max-w-sm --}}
    <main class="flex-1 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-sm">
            @if (session('status'))
                <div class="alert alert-info mb-4">
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- DI SINI tempat halaman masuk --}}
            @yield('content')
        </div>
    </main>

</body>
</html>
