@extends('layouts.mobile-main')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Admin Dashboard</h1>

    {{-- Cards statistik --}}
    <div class="grid grid-cols-2 gap-3 mb-6">

        {{-- Card total user -> ke manajemen user --}}
        <a href="{{ route('admin.users.index') }}"
           class="bg-white rounded-xl shadow p-3 block hover:bg-blue-50 transition-colors">
            <p class="text-xs text-gray-500">Total Pengguna</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalUsers }}</p>
            <p class="text-[11px] text-gray-400 mt-1">
                Kelola pengguna →
            </p>
        </a>

        {{-- Card total post -> ke manajemen post --}}
        <a href="{{ route('admin.posts.index') }}"
           class="bg-white rounded-xl shadow p-3 block hover:bg-blue-50 transition-colors">
            <p class="text-xs text-gray-500">Total Postingan</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalPosts }}</p>
            <p class="text-[11px] text-gray-400 mt-1">
                Kelola postingan →
            </p>
        </a>
    </div>

    {{-- Pengguna terbaru --}}
    <div class="mb-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-2">Pengguna Terbaru</h2>

        @if($latestUsers->isEmpty())
            <p class="text-xs text-gray-500">Belum ada pengguna terdaftar.</p>
        @else
            <div class="bg-white rounded-xl shadow divide-y">
                @foreach($latestUsers as $user)
                    <div class="p-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $user->name }}
                                @if($user->role === 'admin')
                                    <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-blue-100 text-blue-700">
                                        ADMIN
                                    </span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $user->email }}
                            </p>
                            <p class="text-[10px] text-gray-400">
                                Bergabung {{ $user->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-[11px] px-2 py-1 rounded-lg border border-gray-300">
                            Kelola
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Postingan terbaru --}}
    <div class="mb-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-2">Postingan Terbaru</h2>

        @if($latestPosts->isEmpty())
            <p class="text-xs text-gray-500">Belum ada postingan.</p>
        @else
            <div class="space-y-2">
                @foreach($latestPosts as $post)
                    <div class="bg-white rounded-xl shadow p-3 text-sm">
                        <p class="font-semibold text-gray-900">
                            {{ $post->title ?? \Illuminate\Support\Str::limit($post->body, 40) }}
                        </p>
                        <p class="text-xs text-gray-500">
                            oleh {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                        </p>

                        <div class="mt-2 flex justify-end gap-2 text-[11px]">
                            <a href="{{ route('posts.show', $post) }}"
                               class="px-2 py-1 rounded-lg border border-gray-300">
                                Lihat
                            </a>
                            <a href="{{ route('admin.posts.index', ['post_id' => $post->id]) }}"
                               class="px-2 py-1 rounded-lg bg-blue-600 text-white">
                                Kelola
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
