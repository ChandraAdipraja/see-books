@extends('layouts.mobile-guest')

@section('content')
<div class="bg-blue-500 rounded-xl">

    {{-- TITLE --}}
    <div class="text-justify px-6 pt-8 pb-4">
        <h1 class="text-2xl font-bold text-white mb-2">Reset Password</h1>
        <p class="text-sm text-white/90">
            Silakan masukkan password baru kamu untuk melanjutkan.
        </p>
    </div>

    {{-- FORM RESET PASSWORD --}}
    <form method="POST" action="{{ route('password.store') }}" class="card bg-white shadow p-5 rounded-t-2xl">
        @csrf

        {{-- Password Reset Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email (hidden but required) --}}
        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium mb-1">Password Baru</label>
            <input
                id="password"
                name="password"
                type="password"
                class="input input-bordered w-full rounded-lg"
                required
                autofocus
                autocomplete="new-password"
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
                autocomplete="new-password"
            />
            @error('password_confirmation')
                <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- SUBMIT BUTTON --}}
        <button class="btn btn-primary w-full bg-blue-500 px-4 py-2 rounded-lg text-white">
            Reset Password
        </button>

        {{-- BACK TO LOGIN --}}
        <div class="mt-4 text-center text-sm">
            Kembali ke?
            <a class="link link-primary" href="{{ route('login') }}">Masuk</a>
        </div>
    </form>
</div>
@endsection
