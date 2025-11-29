@props([
    'username' => 'Nama User',
    'initial' => null,
    'semester' => null,
    'course' => null,
    'meeting' => null,
    'time' => null,
])

@php
    $initial = $initial ?? strtoupper(substr($username, 0, 1));
@endphp

<div class="flex items-start gap-3 mb-4">
    <div class="w-12 h-12 rounded-full bg-blue-100 overflow-hidden flex items-center justify-center">
        <span class="text-xl font-bold text-blue-700">{{ $initial }}</span>
    </div>

    <div class="flex-1">
        <h2 class="text-md font-semibold">{{ $username }}</h2>
        <p class="text-xs text-gray-400">
            @if($semester) Semester {{ $semester }} @endif
            @if($course) • {{ $course }} @endif
            @if($meeting) • Pertemuan {{ $meeting }} @endif
        </p>
        @if($time)
            <p class="text-[10px] text-gray-400 mt-1">{{ $time }}</p>
        @endif
    </div>

    {{-- Menu titik tiga --}}
    <button class="p-1 hover:bg-gray-100 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="5" cy="12" r="1.5"/>
            <circle cx="12" cy="12" r="1.5"/>
            <circle cx="19" cy="12" r="1.5"/>
        </svg>
    </button>
</div>
