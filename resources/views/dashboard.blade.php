@extends('layouts.mobile-main')

@section('content')
    {{-- FORM SEARCH & FILTER --}}
    <form method="GET" action="{{ route('dashboard') }}" id="filter-form" class="space-y-2 mb-3">
        {{-- Search --}}
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="q" value="{{ $q }}"
                class="input input-bordered w-full pl-9 rounded-full text-sm"
                placeholder="Cari judul, isi catatan, atau mata kuliah...">
        </div>

        <div class="flex justify-between items-center">
            {{-- Filter aktif sebagai chip kecil --}}
            <div class="flex flex-wrap gap-1 text-[10px] text-gray-600">
                @if ($semester)
                    <span class="px-2 py-1 rounded-full bg-gray-100">
                        Sem {{ $semester }}
                    </span>
                @endif
                @if ($course)
                    <span class="px-2 py-1 rounded-full bg-gray-100">
                        {{ $course }}
                    </span>
                @endif
                @if ($meeting)
                    <span class="px-2 py-1 rounded-full bg-gray-100">
                        Pertemuan {{ $meeting }}
                    </span>
                @endif
                @if (!$semester && !$course && !$meeting)
                    <span class="text-gray-400">Tanpa filter</span>
                @endif
            </div>

            {{-- Tombol buka modal filter --}}
            <button type="button" id="openFilter"
                class="text-xs px-3 py-1.5 rounded-full border border-gray-300 flex items-center gap-1">
                <i class="fa-solid fa-sliders"></i>
                <span>Filter</span>
            </button>
        </div>

        {{-- Hidden input utk kirim nilai filter dari modal --}}
        <input type="hidden" name="semester" id="semesterHidden" value="{{ $semester }}">
        <input type="hidden" name="course" id="courseHidden" value="{{ $course }}">
        <input type="hidden" name="meeting" id="meetingHidden" value="{{ $meeting }}">
    </form>

    @forelse ($posts as $post)
        @php
            $isOwner = auth()->check() && auth()->id() === $post->user_id;
        @endphp
        <a href="{{ route('posts.show', $post) }}">
            <x-post-card :postId="$post->id" :isOwner="$isOwner" :name="$post->user->name" :avatar="$post->user->avatar ? asset('storage/' . $post->user->avatar) : null" :semester="$post->semester"
                :course="$post->course" :meeting="$post->meeting" :image="$post->images->first() ? asset('storage/' . $post->images->first()->path) : null" :comments="$post->comments()->count() ?? 0" :downloadUrl="route('posts.show', $post)"
                {{-- sementara bisa ke detail / nanti ke file --}}>
                {{ Str::limit($post->body, 160) }}
            </x-post-card>
        </a>
    @empty
        <p class="text-sm text-gray-500">
            Belum ada postingan. Coba buat catatan pertama kamu ✨
        </p>
    @endforelse
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const coursesBySemester = @json($coursesBySemester);
            const allCourses = @json($allCourses);

            const semesterSelect = document.getElementById('semesterSelect');
            const courseSelect = document.getElementById('courseSelect');

            function rebuildCourseOptions(filterSemesterValue) {
                const currentSelected = courseSelect.value;

                // clear
                courseSelect.innerHTML = '';

                const defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.textContent = 'Semua Mata Kuliah';
                courseSelect.appendChild(defaultOpt);

                let source;
                if (filterSemesterValue) {
                    const key = String(filterSemesterValue);
                    source = coursesBySemester[key] || [];
                } else {
                    source = allCourses;
                }

                source.forEach(name => {
                    const opt = document.createElement('option');
                    opt.value = name;
                    opt.textContent = name;
                    courseSelect.appendChild(opt);
                });

                if (source.includes(currentSelected)) {
                    courseSelect.value = currentSelected;
                }
            }

            // Semester berubah → filter list matkul
            semesterSelect.addEventListener('change', () => {
                const semVal = semesterSelect.value;
                rebuildCourseOptions(semVal);
            });

            // Matkul berubah → set semester otomatis
            courseSelect.addEventListener('change', () => {
                const chosen = courseSelect.value;
                if (!chosen) return;

                let foundSemester = null;
                Object.keys(coursesBySemester).forEach(semKey => {
                    if (coursesBySemester[semKey].includes(chosen)) {
                        foundSemester = semKey;
                    }
                });

                if (foundSemester) {
                    semesterSelect.value = String(foundSemester);
                    rebuildCourseOptions(foundSemester);
                    courseSelect.value = chosen;
                }
            });

            // Init awal: kalau sudah ada semester terpilih (dari query), sync matkul
            if (semesterSelect.value) {
                rebuildCourseOptions(semesterSelect.value);
            }
        });
    </script>
@endsection
