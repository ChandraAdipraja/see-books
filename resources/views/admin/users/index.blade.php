@extends('layouts.mobile-main')

@section('content')
    <div class="flex items-center mb-4">
        <button onclick="history.back()" class="text-gray-700 text-xl mr-2">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h1 class="text-lg font-semibold">Manajemen User</h1>
    </div>

    <div class="flex items-center justify-end mb-4">
        <a href="{{ route('admin.users.create') }}"
           class="text-sm bg-blue-600 text-white px-3 py-1.5 rounded-lg">
            + Tambah
        </a>
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
        <input
            type="text"
            name="q"
            value="{{ $search }}"
            class="input input-bordered w-full rounded-lg text-sm"
            placeholder="Cari nama, email, atau username...">
    </form>

    {{-- Notif --}}
    @if(session('status'))
        <div class="mb-3 text-xs text-green-700 bg-green-100 px-3 py-2 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    @error('delete')
        <div class="mb-3 text-xs text-red-700 bg-red-100 px-3 py-2 rounded-lg">
            {{ $message }}
        </div>
    @enderror

    @if ($users->isEmpty())
        <p class="text-sm text-gray-500">Belum ada user.</p>
    @else
        <div class="bg-white rounded-xl shadow divide-y">
            @foreach ($users as $user)
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

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-xs px-2 py-1 rounded-lg border border-gray-300">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-xs px-2 py-1 rounded-lg bg-red-500 text-white">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
@endsection
