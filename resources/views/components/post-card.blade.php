@props([
    'avatar' => null,
    'name' => 'Nama Mahasiswa',
    'semester' => null,
    'course' => null,
    'meeting' => null,
    'image' => null,
    'likes' => 0,
    'comments' => 0,
    'downloadUrl' => '#',
    'postId',
    'isOwner' => false,
])

<div {{ $attributes->merge(['class' => 'card bg-white shadow rounded-2xl mb-4 overflow-hidden']) }}>

    {{-- HEADER POST --}}
    <div class="px-4 pt-4 pb-2 flex items-start justify-between gap-3">
        <div class="flex items-start gap-3">
            {{-- Avatar --}}
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                @if ($avatar)
                    <img src="{{ $avatar }}" alt="{{ $name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-semibold text-blue-700">
                        {{ strtoupper(substr($name, 0, 1)) }}
                    </span>
                @endif
            </div>

            {{-- Nama + meta --}}
            <div class="flex flex-col">
                <span class="text-sm font-semibold text-gray-900">
                    {{ $name }}
                </span>
                <span class="text-xs text-gray-500">
                    @if ($semester)
                        Semester {{ $semester }}
                    @endif

                    @if ($course)
                        • {{ $course }}
                    @endif

                    @if ($meeting)
                        • Pertemuan {{ $meeting }}
                    @endif
                </span>
            </div>
        </div>
    </div>

    {{-- BODY POST --}}
    @if ($image)
        <div class="mt-2">
            <img src="{{ $image }}" alt="Gambar postingan" class="w-full max-h-80 object-cover">
        </div>
    @endif

    @if (trim($slot))
        <div class="px-4 pt-3 text-sm text-gray-800">
            {{ $slot }} {{-- caption / deskripsi catatan --}}
        </div>
    @endif

    {{-- FOOTER AKSI --}}
    <div class="border-t border-gray-200 mt-3">
        <div class="flex items-center justify-center gap-8 text-sm text-gray-600 px-2 py-2">

            {{-- Comment --}}
            <a href="{{ route('posts.show', $postId) }}" class="inline-flex items-center gap-1 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h8m-8 4h5m-9 4l2-3h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10z" />
                </svg>
                <span>Komentar</span>
                @if ($comments)
                    <span class="text-xs text-gray-400">({{ $comments }})</span>
                @endif
            </a>

            {{-- Download --}}
            <a href="{{ $downloadUrl }}" class="inline-flex items-center gap-1 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v12m0 0l-4-4m4 4l4-4" />
                </svg>
                <span>Unduh</span>
            </a>

            {{-- Delete (hanya pemilik) --}}
            @if ($isOwner)
                <form method="POST" action="{{ route('posts.destroy', $postId) }}"
                    onsubmit="return confirm('Yakin ingin menghapus postingan ini?')" class="inline-flex items-center">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-1 hover:text-red-600 text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 7h12M10 11v6M14 11v6M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M5 7h14l-1 12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 7z" />
                        </svg>
                        <span>Hapus</span>
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>
