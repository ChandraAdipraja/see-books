@extends('layouts.mobile-main')

@section('content')
    <div class="flex items-center mb-4">
        <button onclick="history.back()" class="text-gray-700 text-xl mr-2">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h1 class="text-lg font-semibold">Manajemen Postingan</h1>
    </div>

    {{-- Form Search --}}
    <form method="GET" action="{{ route('admin.posts.index') }}" class="mb-4">
        <input
            type="text"
            name="q"
            value="{{ $search }}"
            class="input input-bordered w-full rounded-lg text-sm"
            placeholder="Cari judul, isi catatan, atau mata kuliah...">
    </form>

    {{-- Notifikasi status --}}
    @if(session('status'))
        <div class="mb-3 text-xs text-green-700 bg-green-100 px-3 py-2 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    {{-- Jika tidak ada post --}}
    @if($posts->isEmpty())
        <p class="text-sm text-gray-500">Belum ada postingan yang ditemukan.</p>
    @else
        <div class="space-y-2">
            @foreach($posts as $post)
                <div class="bg-white rounded-xl shadow p-3 text-sm">
                    {{-- Judul / ringkasan --}}
                    <p class="font-semibold text-gray-900">
                        {{ $post->title ?? \Illuminate\Support\Str::limit($post->body, 50) }}
                    </p>

                    {{-- Meta info --}}
                    <p class="text-xs text-gray-500 mt-1">
                        oleh {{ $post->user->name }}
                        @if($post->course)
                            • {{ $post->course }}
                        @endif
                        @if($post->semester)
                            • Semester {{ $post->semester }}
                        @endif
                        @if($post->meeting)
                            • Pertemuan {{ $post->meeting }}
                        @endif
                    </p>

                    <p class="text-[10px] text-gray-400">
                        Diposting {{ $post->created_at->diffForHumans() }}
                    </p>

                    {{-- Aksi --}}
                    <div class="mt-3 flex justify-end gap-2 text-[11px]">
                        {{-- Lihat postingan di halaman user --}}
                        <a href="{{ route('posts.show', $post) }}"
                           class="px-2 py-1 rounded-lg border border-gray-300">
                            Lihat
                        </a>

                        {{-- Hapus postingan --}}
                        <form method="POST"
                              action="{{ route('admin.posts.destroy', $post) }}"
                              onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 rounded-lg bg-red-500 text-white">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
