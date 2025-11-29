@extends('layouts.mobile-guest')

@section('content')
<div class="bg-blue-500 rounded-xl">
    
    {{-- LOGO --}}
    <div class="flex items-center justify-center mb-2 pt-4">
        <img src="{{ asset('img/seebooks.png') }}" alt="Logo" class="w-32 h-32 bg-white p-4 rounded-full">
    </div>

    {{-- TITLE --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-white">Daftar Akun</h1>
        <p class="text-sm text-white">Buat akun untuk mulai berbagi catatan</p>
    </div>

    {{-- ERROR GLOBAL --}}
    @if ($errors->any())
        <div class="alert alert-error mb-4">
            <span>Ada kesalahan pada data yang kamu masukkan.</span>
        </div>
    @endif

    {{-- FORM REGISTER --}}
    <form method="POST" action="{{ route('register') }}" class="card bg-white shadow p-5 rounded-t-2xl">
        @csrf

        {{-- NAMA --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input
                id="name"
                name="name"
                type="text"
                class="input input-bordered w-full rounded-lg"
                value="{{ old('name') }}"
                required
            />
            @error('name')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- USERNAME --}}
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium mb-1">Username</label>
            <input
                id="username"
                name="username"
                type="text"
                class="input input-bordered w-full rounded-lg"
                value="{{ old('username') }}"
                required
            />
            @error('username')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="input input-bordered w-full rounded-lg"
                value="{{ old('email') }}"
                required
            />
            @error('email')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium mb-1">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="input input-bordered w-full rounded-lg"
                required
            />
            @error('password')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium mb-1">Konfirmasi Password</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="input input-bordered w-full rounded-lg"
                required
            />
        </div>

        {{-- TOMBOL DAFTAR --}}
        <button class="btn btn-primary w-full bg-blue-500 px-4 py-2 rounded-lg text-white">
            Daftar
        </button>

        {{-- LINK KE LOGIN --}}
        <div class="mt-4 text-center text-sm">
            Sudah punya akun?
            <a class="link link-primary" href="{{ route('login') }}">Masuk</a>
        </div>
    </form>

</div>
@endsection
