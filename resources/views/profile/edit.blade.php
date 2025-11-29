@extends('layouts.mobile-plain')

@section('content')

    {{-- Tombol Back --}}
    <div class="flex mb-4">
        <button onclick="history.back()" class="text-gray-700 text-xl">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>

    {{-- AVATAR SECTION --}}
    <div class="flex flex-col items-center mb-6">
        
        <label for="avatar" class="relative cursor-pointer group">

            {{-- Avatar Preview --}}
            <div id="avatarPreview"
                class="w-24 h-24 rounded-full bg-blue-200 overflow-hidden flex items-center justify-center">

                @php
                    $user = Auth::user();
                @endphp

                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                        alt="Avatar"
                        class="w-full h-full object-cover">
                @else
                    <span id="avatarInitial" class="text-3xl font-bold text-blue-700">
                        {{ strtoupper(substr($user->username ?? $user->name, 0, 1)) }}
                    </span>
                @endif
            </div>

            {{-- Icon kamera --}}
            <div
                class="absolute bottom-1 right-1 bg-black/70 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs border border-white">
                <i class="fa-solid fa-camera"></i>
            </div>

        </label>

        {{-- Hidden file input --}}
        <p class="text-xs text-gray-500 mt-2">Ketuk foto untuk mengganti gambar profil</p>

        @error('avatar')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror

    </div>

    {{-- FORM EDIT --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

                <input
            id="avatar"
            name="avatar"
            type="file"
            accept="image/*"
            class="hidden">

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium mb-1" for="name">Nama</label>
            <input
                id="name"
                name="name"
                type="text"
                class="input input-bordered w-full rounded-lg"
                value="{{ old('name', $user->name) }}"
                required>
        </div>

        {{-- Bio --}}
        <div>
            <label class="block text-sm font-medium mb-1" for="bio">Bio</label>
            <textarea
                id="bio"
                name="bio"
                rows="3"
                class="textarea textarea-bordered w-full rounded-lg resize-none"
                placeholder="Tuliskan sedikit tentang dirimu...">{{ old('bio', $user->bio ?? '') }}</textarea>
        </div>

        {{-- Tombol simpan --}}
        <div class="pt-2">
            <button class="p-4 bg-blue-600 text-white w-full rounded-lg">Simpan Perubahan</button>
        </div>

    </form>

    {{-- AVATAR PREVIEW SCRIPT --}}
    <script>
        document.getElementById('avatar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            const previewContainer = document.getElementById('avatarPreview');
            const initialText = document.getElementById('avatarInitial');

            if (initialText) initialText.style.display = 'none';

            const oldImg = previewContainer.querySelector("img");
            if (oldImg) oldImg.remove();

            const img = document.createElement("img");
            img.classList.add("w-full", "h-full", "object-cover");

            const reader = new FileReader();
            reader.onload = () => { img.src = reader.result; };
            reader.readAsDataURL(file);

            previewContainer.appendChild(img);
        });
    </script>

@endsection
