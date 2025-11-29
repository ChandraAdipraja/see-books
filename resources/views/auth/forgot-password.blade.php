@extends('layouts.mobile-guest')

@section('content')
<div class="bg-blue-500 rounded-xl">

    {{-- TITLE --}}
    <div class="px-4 mb-6 pt-4 text-justify">
        <h1 class="text-2xl font-bold text-white">Lupa Password?</h1>
        <p class="text-sm text-white">Masukkan email untuk reset password</p>
    </div>

    <!-- {{-- SUCCESS MESSAGE --}}
    @if (session('status')) -->
        <div class="alert alert-success mb-4">
            <span>sss</span>
        </div>
    <!-- @endif -->

    {{-- FORM FORGOT PASSWORD --}}
    <form method="POST" action="{{ route('password.email') }}" class="card bg-white shadow p-5 rounded-t-2xl">
        @csrf

        {{-- Email --}}
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="input input-bordered w-full rounded-lg"
                required
                autofocus
                value="{{ old('email') }}"
            />
            @error('email')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <button class="btn btn-primary w-full bg-blue-500 px-4 py-2 rounded-lg text-white">
            Kirim Link Reset
        </button>

        {{-- LINK KE LOGIN --}}
        <div class="mt-4 text-center text-sm">
            Ingat password?
            <a class="link link-primary" href="{{ route('login') }}">Masuk</a>
        </div>
    </form>

</div>
@endsection
