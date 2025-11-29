@extends('layouts.mobile-plain')

@section('content')

    {{-- BACK BUTTON --}}
    <div class="flex mb-4">
        <button onclick="history.back()" class="text-gray-700 text-xl">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>

    @php
        $user = $post->user;

        // build array URL gambar dari relasi
        $images = $post->images
            ? $post->images->sortBy('order')->map(fn($img) => asset('storage/' . $img->path))->values()->all()
            : [];
    @endphp

    {{-- Header Info Post --}}
    <div class="flex items-start gap-3 mb-4">
        {{-- Avatar --}}
        <div class="w-12 h-12 rounded-full bg-blue-100 overflow-hidden flex items-center justify-center">
            @if (!empty($user->avatar))
                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover"
                    alt="{{ $user->name }}">
            @else
                <span class="text-xl font-bold text-blue-700">
                    {{ strtoupper(substr($user->username ?? $user->name, 0, 1)) }}
                </span>
            @endif
        </div>

        <div class="flex-1">
            <h2 class="text-md font-semibold">
                {{ $user->name }}
            </h2>
            <p class="text-xs text-gray-400">
                @if ($post->semester)
                    Semester {{ $post->semester }}
                @endif

                @if ($post->course)
                    • {{ $post->course }}
                @endif

                @if ($post->meeting)
                    • Pertemuan {{ $post->meeting }}
                @endif
            </p>
            <p class="text-[10px] text-gray-400 mt-1">
                {{ $post->created_at?->diffForHumans() }}
            </p>
        </div>

        {{-- Menu titik tiga --}}
        <button class="p-1 hover:bg-gray-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                <circle cx="5" cy="12" r="1.5" />
                <circle cx="12" cy="12" r="1.5" />
                <circle cx="19" cy="12" r="1.5" />
            </svg>
        </button>
    </div>

    {{-- JUDUL POST (opsional) --}}
    @if ($post->title)
        <h1 class="text-lg font-semibold mb-2">{{ $post->title }}</h1>
    @endif

    {{-- CAROUSEL GAMBAR --}}
    @if (count($images))
        <div class="relative w-full mb-4">
            <div id="post-carousel" class="overflow-hidden rounded-lg">
                @foreach ($images as $index => $img)
                    <div class="carousel-slide {{ $index === 0 ? 'block' : 'hidden' }}">
                        <img src="{{ $img }}" class="w-full max-h-80 object-cover">
                    </div>
                @endforeach
            </div>

            @if (count($images) > 1)
                {{-- Tombol Prev / Next --}}
                <div class="flex justify-center gap-2 pt-2">
                    <button type="button" id="carousel-prev"
                        class="z-10 bg-blue-500 text-white w-16 h-8 rounded-full
                           flex items-center justify-center text-sm shadow">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <button type="button" id="carousel-next"
                        class="z-10 bg-blue-500 text-white w-16 h-8 rounded-full
                           flex items-center justify-center text-sm shadow">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

                {{-- Indicator dots --}}
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5">
                    @foreach ($images as $index => $img)
                        <button type="button"
                            class="carousel-dot w-2 h-2 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}"
                            data-index="{{ $index }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- Deskripsi / Caption --}}
    <p class="text-sm text-gray-800 mb-4 whitespace-pre-line">
        {{ $post->body }}
    </p>

    {{-- Aksi --}}
    <div class="flex items-center justify-around border-y py-3 mb-4 text-gray-600 text-sm">
        {{-- Comment --}}
        <button class="flex items-center gap-1 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h8m-8 4h5m-9 4l2-3h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10z" />
            </svg>
            <span>Komentar</span>
        </button>

        {{-- Download catatan (untuk sekarang bisa diarahkan ke PDF / gambar pertama) --}}
        <a href="#" class="flex items-center gap-1 hover:text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v12m0 0l-4-4m4 4l4-4" />
            </svg>
            <span>Unduh</span>
        </a>

        {{-- ACTION ROW (hapus kalau pemilik atau admin) --}}
        @if (auth()->id() === $post->user_id || auth()->user()->role === 'admin')
            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="inline-flex items-center"
                onsubmit="return confirm('Apakah kamu yakin ingin menghapus postingan ini?')" class="mt-3">
                @csrf
                @method('DELETE')

                <button type="submit" class="flex items-center gap-1 hover:text-red-600 text-red-500 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 7h12M10 11v6M14 11v6M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M5 7h14l-1 12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 7z" />
                        </svg>
                        <span>Hapus</span>
                    </button>
            </form>
        @endif
    </div>

    {{-- KOMENTAR (sementara dummy) --}}
    <h3 class="font-semibold text-gray-800 mb-2">Komentar</h3>

    @foreach ($post->comments as $comment)
        <div class="flex gap-3 mb-4">
            <div class="w-9 h-9 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center self-center">
                @if ($comment->user->avatar)
                    <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-full h-full object-cover"
                        alt="Avatar">
                @else
                    <span class="text-gray-700 font-bold text-sm">
                        {{ strtoupper(substr($comment->user->username ?? $comment->user->name, 0, 1)) }}
                    </span>
                @endif
            </div>

            <div class="flex-1 bg-white p-3 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold">{{ $comment->user->name }}</p>
                    <p class="text-[10px] text-gray-400">
                        {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>

                <p class="text-sm text-gray-700">{{ $comment->body }}</p>

                {{-- tombol hapus kalau boleh --}}
                @if (auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === 'admin'))
                    <form method="POST" action="{{ route('comments.destroy', [$post, $comment]) }}"
                        onsubmit="return confirm('Hapus komentar ini?')" class="mt-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[11px] text-red-500 hover:text-red-600">
                            Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach


    <div class="fixed bottom-0 left-0 w-full bg-white border-t px-4 py-3 z-20">
        <form method="POST" action="{{ route('comments.store', $post) }}" class="max-w-md mx-auto flex gap-2 w-full">
            @csrf

            <input type="text" name="body" class="input input-bordered w-full rounded-lg"
                placeholder="Tulis komentar..." required>

            <button class="btn bg-blue-600 text-white rounded-lg w-14 flex justify-center items-center">
                <i class="fa-regular fa-paper-plane text-lg"></i>
            </button>
        </form>
    </div>


    {{-- SCRIPT CAROUSEL --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = Array.from(document.querySelectorAll('.carousel-slide'));
            const dots = Array.from(document.querySelectorAll('.carousel-dot'));
            const prev = document.getElementById('carousel-prev');
            const next = document.getElementById('carousel-next');

            if (slides.length === 0) return;

            let current = 0;

            function showSlide(index) {
                slides.forEach((s, i) => {
                    s.classList.toggle('hidden', i !== index);
                    s.classList.toggle('block', i === index);
                });

                if (dots.length) {
                    dots.forEach((d, i) => {
                        d.classList.toggle('bg-white', i === index);
                        d.classList.toggle('bg-white/50', i !== index);
                    });
                }

                current = index;
            }

            prev && prev.addEventListener('click', () => {
                const idx = (current - 1 + slides.length) % slides.length;
                showSlide(idx);
            });

            next && next.addEventListener('click', () => {
                const idx = (current + 1) % slides.length;
                showSlide(idx);
            });

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const idx = parseInt(dot.dataset.index, 10);
                    showSlide(idx);
                });
            });

            showSlide(0);
        });
    </script>

@endsection
