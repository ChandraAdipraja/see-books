@props([
    'images' => [],
    'id' => 'post-carousel', // unik per halaman kalau mau
])

@if (count($images))
<div class="relative w-full mb-4">
    <div id="{{ $id }}" class="overflow-hidden rounded-lg">
        @foreach ($images as $index => $img)
            <div class="carousel-slide {{ $index === 0 ? 'block' : 'hidden' }}">
                <img src="{{ $img }}" class="w-full max-h-80 object-cover">
            </div>
        @endforeach
    </div>

    @if (count($images) > 1)
        <div class="flex justify-center gap-2 pt-2">
            {{-- Prev --}}
            <button
                type="button"
                id="{{ $id }}-prev"
                class="z-10 bg-blue-500 text-white w-16 h-8 rounded-full
                       flex items-center justify-center text-sm shadow"
            >
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            {{-- Next --}}
            <button
                type="button"
                id="{{ $id }}-next"
                class="z-10 bg-blue-500 text-white w-16 h-8 rounded-full
                       flex items-center justify-center text-sm shadow"
            >
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        {{-- Dots --}}
        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5">
            @foreach ($images as $index => $img)
                <button
                    type="button"
                    class="carousel-dot w-2 h-2 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}"
                    data-index="{{ $index }}"
                ></button>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById(@json($id));
    if (!container) return;

    const slides = Array.from(container.querySelectorAll('.carousel-slide'));
    const dots   = Array.from(container.parentElement.querySelectorAll('.carousel-dot'));
    const prev   = document.getElementById(@json($id) + '-prev');
    const next   = document.getElementById(@json($id) + '-next');

    if (slides.length === 0) return;

    let current = 0;

    function showSlide(index) {
        slides.forEach((s, i) => {
            s.classList.toggle('hidden', i !== index);
            s.classList.toggle('block', i === index);
        });

        if (dots.length) {
            dots.forEach((d, i) => {
                d.classList.toggle('bg-white', i === index);
                d.classList.toggle('bg-white/50', i !== index);
            });
        }

        current = index;
    }

    prev && prev.addEventListener('click', () => {
        const idx = (current - 1 + slides.length) % slides.length;
        showSlide(idx);
    });

    next && next.addEventListener('click', () => {
        const idx = (current + 1) % slides.length;
        showSlide(idx);
    });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const idx = parseInt(dot.dataset.index, 10);
            showSlide(idx);
        });
    });

    showSlide(0);
});
</script>
@endpush
@endif
