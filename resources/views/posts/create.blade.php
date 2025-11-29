@extends('layouts.mobile-main')

@section('content')
    <div class="flex items-center mb-4">
        <button onclick="history.back()" class="text-gray-700 text-xl mr-2">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h1 class="text-lg font-semibold">Tambah Postingan</h1>
    </div>

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        {{-- Judul (opsional) --}}
        <div>
            <label class="block text-sm font-medium mb-1">Judul (opsional)</label>
            <input
                type="text"
                name="title"
                class="input input-bordered w-full rounded-lg text-sm"
                value="{{ old('title') }}"
                placeholder="Misal: Ringkasan materi Rekayasa Perangkat Lunak"
            >
            @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Body / Isi catatan --}}
        <div>
            <label class="block text-sm font-medium mb-1">Isi Catatan</label>
            <textarea
                name="body"
                rows="5"
                class="textarea textarea-bordered w-full rounded-lg text-sm"
                placeholder="Tulis ringkasan materi, poin penting, atau penjelasanmu di sini...">{{ old('body') }}</textarea>
            @error('body') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Semester / Mata Kuliah / Pertemuan --}}
        <div class="grid grid-cols-1 gap-3 text-xs">
            {{-- Semester --}}
            <div>
                <label class="block mb-1 text-gray-600">Semester</label>
                <select
                    name="semester"
                    id="semesterSelect"
                    class="select select-bordered w-full rounded-full text-xs"
                >
                    <option value="">Pilih Semester</option>
                    @foreach($availableSemesters as $smt)
                        <option value="{{ $smt }}" {{ old('semester') == $smt ? 'selected' : '' }}>
                            Semester {{ $smt }}
                        </option>
                    @endforeach
                </select>
                @error('semester') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Mata Kuliah --}}
            <div>
                <label class="block mb-1 text-gray-600">Mata Kuliah</label>
                <select
                    name="course"
                    id="courseSelect"
                    class="select select-bordered w-full rounded-full text-xs"
                >
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach($allCourses as $c)
                        <option value="{{ $c }}" {{ old('course') === $c ? 'selected' : '' }}>
                            {{ $c }}
                        </option>
                    @endforeach
                </select>
                @error('course') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Pertemuan --}}
            <div>
                <label class="block mb-1 text-gray-600">Pertemuan</label>
                <select
                    name="meeting"
                    id="meetingSelect"
                    class="select select-bordered w-full rounded-full text-xs"
                >
                    <option value="">Pilih Pertemuan</option>
                    @foreach($availableMeetings as $mtg)
                        <option value="{{ $mtg }}" {{ old('meeting') == $mtg ? 'selected' : '' }}>
                            Pertemuan {{ $mtg }}
                        </option>
                    @endforeach
                </select>
                @error('meeting') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Upload gambar (boleh multiple) --}}
        <div>
            <label class="block text-sm font-medium mb-1">Lampiran Gambar (opsional)</label>
            <input
                type="file"
                name="images[]"
                multiple
                accept="image/*"
                class="file-input file-input-bordered w-full rounded-lg file-input-sm"
            >
            @error('images.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button class="w-full bg-blue-600 text-white rounded-lg py-2.5 text-sm font-semibold">
                Publikasikan
            </button>
        </div>
    </form>

    {{-- JS: hubungan Semester <-> Mata Kuliah --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const coursesBySemester = @json($coursesBySemester);
            const allCourses        = @json($allCourses);

            const semesterSelect = document.getElementById('semesterSelect');
            const courseSelect   = document.getElementById('courseSelect');

            function rebuildCourseOptions(filterSemesterValue) {
                const currentSelected = courseSelect.value;

                courseSelect.innerHTML = '';
                const defaultOpt = document.createElement('option');
                defaultOpt.value = '';
                defaultOpt.textContent = 'Pilih Mata Kuliah';
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

            // Semester berubah → filter matkul
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

            // Init awal (kalau old() punya semester)
            if (semesterSelect.value) {
                rebuildCourseOptions(semesterSelect.value);
            }
        });
    </script>
@endsection
