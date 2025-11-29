@extends('layouts.mobile-guest')

@section('content')
<div class = "bg-blue-500 rounded-xl pt-8" >
    <div class="flex items-center justify-center mb-2 pt-4">
        <img src="{{ asset('img/seebooks.png') }}" alt="Logo" class="w-32 h-32 bg-white p-4 rounded-full">
    </div>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-white">Masuk</h1>
        <p class="text-sm text-white">Silakan login untuk melanjutkan</p>
    </div>
    
    @if ($errors->has('login'))
    <div class="alert alert-error mb-4">
        <span>{{ $errors->first('login') }}</span>
    </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}" class="card bg-white shadow p-5 rounded-t-2xl">
        @csrf
        
        {{-- Email atau Username --}}
        <div class="mb-4">
            <label for="login" class="block text-sm font-medium mb-1">Email atau Username</label>
            <input
            id="login"
            name="login"
            type="text"
            class="input input-bordered w-full rounded-lg"
            value="{{ old('login') }}"
            required
            autofocus
            autocomplete="username"
            />
            @error('login')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Password --}}
        <div class="mb-2">
            <label for="password" class="block text-sm font-medium mb-1">Password</label>
            <input
            id="password"
            name="password"
            type="password"
            class="input input-bordered w-full rounded-lg"
            required
            autocomplete="current-password"
            />
            @error('password')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex items-center justify-between mb-5">
            
            @if (Route::has('password.request'))
            <a class="link link-primary text-sm" href="{{ route('password.request') }}">
                Lupa password?
            </a>
            @endif
        </div>
        
        <button class="btn btn-primary w-full bg-blue-500 px-4 py-2 rounded-lg text-white">Masuk</button>
        
        <div class="mt-4 text-center text-sm">
            Belum punya akun?
            <a class="link link-primary" href="{{ route('register') }}">Daftar</a>
        </div>
    </form>
</div>
    @endsection
    