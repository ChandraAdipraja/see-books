@extends('layouts.mobile-plain')

@section('content')

{{-- HEADER --}}
<div class="flex justify-start items-center gap-x-2">
    <div class="flex">
        <button onclick="history.back()" class="text-gray-700 text-xl">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>
    <div class="">
        <h1 class="text-xl font-semibold text-gray-900">Pengaturan Akun</h1>
    </div>
</div>

{{-- MENU LIST --}}
<div class="bg-white rounded-xl shadow p-2 divide-y">

    {{-- Reset Password --}}
    <a href="{{ route('profile.password') }}"
       class="flex items-center justify-between p-4 hover:bg-gray-50">
        <span class="text-gray-700 text-sm">Reset Password</span>
        <i class="fa-solid fa-chevron-right text-gray-400"></i>
    </a>

    {{-- Tentang App (opsional) --}}
    <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50">
        <span class="text-gray-700 text-sm">Tentang Aplikasi</span>
        <i class="fa-solid fa-chevron-right text-gray-400"></i>
    </a>

    {{-- Kebijakan Privasi (opsional) --}}
    <a href="#" class="flex items-center justify-between p-4 hover:bg-gray-50">
        <span class="text-gray-700 text-sm">Kebijakan Privasi</span>
        <i class="fa-solid fa-chevron-right text-gray-400"></i>
    </a>

</div>


{{-- LOGOUT BUTTON --}}
<div class="mt-10 flex justify-center">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button
            type="submit"
            class="text-red-600 font-semibold border border-red-600 px-6 py-3 rounded-xl">
            Keluar
        </button>
    </form>
</div>

@endsection
