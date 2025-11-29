@extends('layouts.mobile-plain')

@section('content')
    <div class="flex items-center mb-4">
        <button onclick="history.back()" class="text-gray-700 text-xl mr-2">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h1 class="text-lg font-semibold">Edit User</h1>
    </div>

    <div class="bg-white rounded-2xl shadow p-4">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm mb-1">Nama</label>
                <input type="text" name="name" class="input input-bordered w-full rounded-lg"
                       value="{{ old('name', $user->name) }}" required>
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Username (opsional)</label>
                <input type="text" name="username" class="input input-bordered w-full rounded-lg"
                       value="{{ old('username', $user->username) }}">
                @error('username') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" class="input input-bordered w-full rounded-lg"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Role</label>
                <select name="role" class="select select-bordered w-full rounded-lg" required>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            @error('role')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <div class="pt-2">
                <button class="p-3 bg-blue-600 text-white w-full rounded-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
