@props([
    'likes' => 0,
    'comments' => 0,
])

<div class="flex items-center justify-between border-y py-3 mb-4 text-gray-600 text-sm">

    {{-- Like --}}
    <button class="flex items-center gap-1 hover:text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 15l4-4 4 4 6-6"/>
        </svg>
        <span>Suka ({{ $likes }})</span>
    </button>

    {{-- Comment --}}
    <button class="flex items-center gap-1 hover:text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h8m-8 4h5m-9 4l2-3h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10z"/>
        </svg>
        <span>Komentar ({{ $comments }})</span>
    </button>

    {{-- Download --}}
    <button class="flex items-center gap-1 hover:text-blue-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 3v12m0 0l-4-4m4 4 4-4"/>
        </svg>
        <span>Unduh</span>
    </button>

</div>
