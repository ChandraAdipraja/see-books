@extends('layouts.mobile-main')

@section('content')

@php
    use Illuminate\Support\Str;
@endphp

{{-- HEADER PROFILE --}}
<div class="flex flex-col items-center mt-4 mb-6">

    {{-- Avatar --}}
    <div class="w-24 h-24 rounded-full bg-blue-200 mb-3 overflow-hidden flex items-center justify-center">
        @if (!empty($user->avatar))
            <img src="{{ asset('storage/'.$user->avatar) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
        @else
            <span class="text-3xl font-bold text-blue-700">
                {{ strtoupper(substr($user->username ?? $user->name, 0, 1)) }}
            </span>
        @endif
    </div>

    {{-- Nama & Username --}}
    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
    @if(!empty($user->username))
        <p class="text-sm text-gray-500 -mt-1">{{ $user->username }}</p>
    @endif

    {{-- Bio (opsional) --}}
    @if(!empty($user->bio))
        <p class="text-xs text-gray-600 mt-2 text-center px-6">
            {{ $user->bio }}
        </p>
    @endif

    {{-- Tombol aksi --}}
    <div class="flex gap-3 mt-5">
        <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium">
            Edit Profil
        </a>
        <a href="{{ route('profile.settings') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 text-sm font-medium">
            Pengaturan
        </a>
    </div>

</div>

{{-- LIST POSTINGAN USER --}}
<h3 class="text-md font-semibold text-gray-800 mb-3">Postingan Kamu</h3>

@forelse ($posts as $post)
    <a href="{{ route('posts.show', $post) }}">
        <x-post-card
            :name="$user->name"
            :avatar="$user->avatar ? asset('storage/'.$user->avatar) : null"
            :semester="$post->semester"
            :course="$post->course"
            :meeting="$post->meeting"
            :image="$post->images->first() ? asset('storage/'.$post->images->first()->path) : null"
        >
            {{ Str::limit($post->body, 160) }}
        </x-post-card>
    </a>
@empty
    <p class="text-sm text-gray-500">
        Kamu belum punya postingan. Coba buat catatan pertama kamu di menu <b>Tambah</b> ✨
    </p>
@endforelse

@endsection
