@extends('layouts.mobile-guest')

@section('content')
<div class="bg-blue-500 rounded-xl">

    {{-- TITLE --}}
    <div class="text-justify px-6 pt-8 pb-4">
        <h1 class="text-2xl font-bold text-white mb-2">Verifikasi Email</h1>
        <p class="text-sm text-white/90">
            Terima kasih sudah mendaftar!  
            Silakan cek email kamu dan klik link verifikasi untuk mengaktifkan akun.
        </p>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if (session('status') == 'verification-link-sent')
        <div class="px-5 pb-3">
            <div class="alert bg-green-100 text-green-800 text-sm rounded-lg px-5 pt-3">
                Link verifikasi baru sudah dikirim ke email yang kamu daftarkan.
            </div>
        </div>
    @endif

    {{-- ACTIONS CARD --}}
    <div class="card bg-white shadow p-5 rounded-t-2xl">
        <p class="text-sm text-gray-600 mb-4">
            Tidak menerima email? Kamu bisa meminta kami untuk mengirim ulang link verifikasi.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button
                type="submit"
                class="btn btn-primary w-full bg-blue-500 px-4 py-2 rounded-lg text-white"
            >
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button
                type="submit"
                class="text-xs text-gray-500 hover:text-gray-700 underline"
            >
                Keluar
            </button>
        </form>
    </div>

</div>
@endsection
