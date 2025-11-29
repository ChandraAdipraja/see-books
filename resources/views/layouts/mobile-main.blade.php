<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    </link>

    <title>{{ $title ?? config('app.name', 'SeeBooks') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-base-200 flex flex-col">
    {{-- ===== NAVBAR ===== --}}
    <header class="w-full bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-md mx-auto flex items-center justify-between p-4">
            <div class="text-md font-semibold text-gray-700">
                <h1>Selamat datang, </h1>
                <span class="text-blue-600">{{ Auth::user()->username }}</span>
            </div>
            <a href="{{ route('profile.index') }}" class="relative group">
                <div class="w-10 h-10 rounded-full bg-blue-200 overflow-hidden flex items-center justify-center">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-lg font-semibold text-blue-700">
                            {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                        </span>
                    @endif
                </div>

                {{-- Hover border effect (optional aesthetic) --}}
                <span
                    class="absolute inset-0 rounded-full border-2 border-transparent group-hover:border-blue-400 transition"></span>
            </a>
        </div>
    </header>

    {{-- ===== CONTENT ===== --}}
    <main class="flex-1 max-w-md mx-auto w-full px-4 py-6 pb-24">
        @yield('content')
    </main>

    {{-- ===== BOTTOM NAV ===== --}}
    <footer class="fixed bottom-0 w-full bg-white border-t border-gray-300 shadow-inner">
        <div class="max-w-md mx-auto flex justify-around px-6 py-3 items-center">

            {{-- BERANDA --}}
            <a href="/"
                class="flex flex-col items-center text-sm {{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 mb-1 {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5 0H5" />
                </svg>
                Beranda
            </a>

            {{-- TAMBAH POST --}}
            <a href="{{ route('posts.create') }}"
                class="flex flex-col items-center text-sm {{ request()->routeIs('post.create') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 mb-1 {{ request()->routeIs('post.create') ? 'text-blue-600' : '' }}" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah
            </a>

            {{-- PROFILE --}}
            <a href="/profile"
                class="flex flex-col items-center text-sm {{ request()->routeIs('profile') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 mb-1 {{ request()->routeIs('profile') ? 'text-blue-600' : '' }}" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 017.999 16h8a4 4 0 012.879 1.804M15
                        11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Profil
            </a>

            {{-- ADMIN (hanya untuk role admin) --}}
            @if (Auth::user()?->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex flex-col items-center text-sm
                      {{ request()->routeIs('admin.*') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                    <i class="fa-solid fa-shield-halved w-5 h-5 mb-1 items-center"></i>
                    Admin
                </a>
            @endif
        </div>
    </footer>

</body>

</html>
