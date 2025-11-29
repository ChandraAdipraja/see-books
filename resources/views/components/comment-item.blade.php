@props([
    'user' => 'User',
    'comment' => '',
    'time' => null,
])

<div class="flex gap-3 mb-4">
    <div class="w-9 h-9 my-auto rounded-full bg-gray-200 flex justify-center items-center">
        <span class="text-gray-700 font-bold">
            {{ strtoupper(substr($user, 0, 1)) }}
        </span>
    </div>

    <div class="flex-1 bg-white p-3 rounded-xl shadow-sm">
        <p class="text-sm font-semibold">{{ $user }}</p>
        <p class="text-sm text-gray-700">{{ $comment }}</p>
        @if($time)
            <p class="text-[10px] text-gray-400 mt-1">{{ $time }}</p>
        @endif
    </div>
</div>
