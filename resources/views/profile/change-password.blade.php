@extends('layouts.mobile-plain')

@section('content')

    {{-- Tombol Back --}}
    <div class="flex mb-4">
        <button onclick="history.back()" class="text-gray-700 text-xl">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>

    <h1 class="text-xl font-semibold mb-4">Ubah Password</h1>

    <div class="bg-white rounded-2xl shadow p-4">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Password sekarang --}}
            <div>
                <label for="current_password" class="block text-sm font-medium mb-1">
                    Password saat ini
                </label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="input input-bordered w-full rounded-lg"
                    required
                    autocomplete="current-password"
                >
                @error('current_password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password baru --}}
            <div>
                <label for="password" class="block text-sm font-medium mb-1">
                    Password baru
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="input input-bordered w-full rounded-lg"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi password baru --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-1">
                    Konfirmasi password baru
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="input input-bordered w-full rounded-lg"
                    required
                    autocomplete="new-password"
                >
            </div>

            {{-- Status sukses (opsional) --}}
            @if (session('status') === 'password-updated')
                <p class="text-xs text-green-600">
                    Password berhasil diperbarui.
                </p>
            @endif

            {{-- Tombol simpan --}}
            <div class="pt-2">
                <button class="p-4 bg-blue-600 text-white w-full rounded-lg">
                    Simpan Password
                </button>
            </div>
        </form>
    </div>

@endsection
