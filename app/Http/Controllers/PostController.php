<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    private function coursesBySemester(): array
    {
        return [
            1 => ['Bahasa Indonesia', 'Bahasa Inggris', 'Pancasila', 'Literasi Teknologi Informasi', 'Kalkulus I', 'Kewirausahaan', 'Logika Informatika', 'Dasar Pemrograman'],
            2 => ['Agama', 'Pendidikan Kewarganegaraan', 'Pendidikan Anti Korupsi', 'Kalkulus II', 'Matematika Diskrit', 'Basis Data', 'Algoritma & Struktur Data', 'Perilaku Organisasi'],
            3 => ['Sistem Digital', 'Arsitektur & Organisasi Komputer', 'Rekayasa Perangkat Lunak', 'Pemrograman Berorientasi Objek', 'Pemrograman Sistem', 'Aljabar Linier & Matriks', 'Statistika & Probabilitas'],
            4 => ['Analisa Numerik', 'Jaringan Komputer', 'Pemodelan & Simulasi', 'Sistem Informasi', 'Sistem Operasi', 'Keamanan Informasi', 'Pemrograman Web'],
            5 => ['Kecerdasan Buatan', 'Pemrosesan Data Terdistribusi', 'Pengembangan Aplikasi Berbasis Platform', 'Interaksi Manusia-Komputer', 'Komputasi Awan', 'Teori Bahasa & Otomata', 'Teori Informasi', 'Data Science'],
            6 => ['Metodologi Penelitian', 'Etika Profesi', 'Grafika Komputer', 'Pembelajaran Mesin', 'Sosioteknologi Informasi'],
            7 => ['Kuliah Kerja Nyata', 'Kerja Praktek', 'Manajemen Proyek Perangkat Lunak', 'Pengujian & Implementasi Sistem'],
            8 => ['Tugas Akhir / Skripsi'],
        ];
    }
    public function index(Request $request)
    {
        // Mapping matkul per semester (fix)
        $coursesBySemester = $this->coursesBySemester();

        // Semua matkul (untuk combobox matkul global)
        $allCourses = collect($coursesBySemester)->flatten()->values();

        // Input filter
        $q = $request->get('q');
        $semester = $request->get('semester'); // "1".."8" atau null
        $course = $request->get('course'); // nama matkul atau null
        $meeting = $request->get('meeting'); // nomor pertemuan atau null

        // === LOGIC KETERGANTUNGAN MATKUL ↔ SEMESTER ===

        // 1. Kalau user pilih matkul tapi semester kosong → isi semester otomatis
        if ($course && !$semester) {
            foreach ($coursesBySemester as $sem => $list) {
                if (in_array($course, $list, true)) {
                    $semester = (string) $sem;
                    break;
                }
            }
        }

        // 2. Kalau user pilih dua-duanya tapi tidak cocok → paksa semester ikut matkul
        if ($course && $semester) {
            $belongs = false;

            foreach ($coursesBySemester as $sem => $list) {
                if (in_array($course, $list, true)) {
                    $belongs = true;

                    if ((string) $sem !== (string) $semester) {
                        // override semester supaya konsisten
                        $semester = (string) $sem;
                    }
                    break;
                }
            }

            // Kalau matkul ga ada di mapping, abaikan filter matkul
            if (!$belongs) {
                $course = null;
            }
        }

        // Query posts
        $posts = Post::with(['user', 'images'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('title', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%")
                        ->orWhere('course', 'like', "%{$q}%");
                });
            })
            ->when($semester, fn($q) => $q->where('semester', $semester))
            ->when($course, fn($q) => $q->where('course', $course))
            ->when($meeting, fn($q) => $q->where('meeting', $meeting))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Opsi combobox
        $availableSemesters = collect(array_keys($coursesBySemester))->sort()->values();
        $availableMeetings = collect(range(1, 16)); // bebas, bisa ganti max pertemuan

        return view('dashboard', [
            'posts' => $posts,
            'q' => $q,
            'semester' => $semester,
            'course' => $course,
            'meeting' => $meeting,
            'availableSemesters' => $availableSemesters,
            'availableMeetings' => $availableMeetings,
            'coursesBySemester' => $coursesBySemester,
            'allCourses' => $allCourses,
        ]);
    }

    // form tambah postingan
    public function create()
    {
        $coursesBySemester = $this->coursesBySemester();
        $availableSemesters = collect(array_keys($coursesBySemester))->sort()->values();
        $allCourses = collect($coursesBySemester)->flatten()->values();
        $availableMeetings = collect(range(1, 16)); // misal max 16 pertemuan

        return view('posts.create', compact('coursesBySemester', 'availableSemesters', 'allCourses', 'availableMeetings'));
    }

    // simpan postingan baru
    public function store(Request $request)
    {
        $coursesBySemester = $this->coursesBySemester();
        $availableSemesters = array_keys($coursesBySemester);
        $allCourses = collect($coursesBySemester)->flatten()->values()->toArray();

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'semester' => ['nullable', 'integer', Rule::in($availableSemesters)],
            'course' => ['nullable', 'string', Rule::in($allCourses)],
            'meeting' => ['nullable', 'integer', 'min:1', 'max:16'],
            'images.*' => ['nullable', 'image', 'max:2048'], // kalau ada upload gambar
        ]);

        // logika "matkul -> semester" kalau user cuma pilih matkul
        if ($validated['course'] ?? false) {
            $currentSemester = $validated['semester'] ?? null;

            foreach ($coursesBySemester as $sem => $list) {
                if (in_array($validated['course'], $list, true)) {
                    // kalau semester belum diisi atau salah, paksa ikut semester matkul
                    if ((string) $currentSemester !== (string) $sem) {
                        $validated['semester'] = $sem;
                    }
                    break;
                }
            }
        }

        // buat slug dasar dari judul atau isi body
        $baseSlug = Str::slug($validated['title'] ?? Str::limit($validated['body'], 50, ''));

        // fallback kalau kosong banget
        if ($baseSlug === '') {
            $baseSlug = Str::random(8);
        }

        // pastikan unik
        $slug = $baseSlug;
        $counter = 1;

        while (\App\Models\Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'] ?? null,
            'body' => $validated['body'],
            'semester' => $validated['semester'] ?? null,
            'course' => $validated['course'] ?? null,
            'meeting' => $validated['meeting'] ?? null,
            'slug' => $slug,
        ]);

        // simpan gambar kalau ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $idx => $file) {
                $path = $file->store('posts', 'public');

                $post->images()->create([
                    'path' => $path,
                    'order' => $idx,
                ]);
            }
        }

        return redirect()->route('posts.show', $post)->with('status', 'Postingan berhasil dibuat.');
    }

    // detail postingan (pakai yang sudah kamu desain)
    public function show(Post $post)
    {
        $post->load('user', 'images');

        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        // Cek: hanya pemilik yang boleh hapus
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak punya izin untuk menghapus postingan ini.');
        }

        // Hapus file gambar di storage (kalau ada relasi images)
        foreach ($post->images as $image) {
            if ($image->path) {
                Storage::disk('public')->delete($image->path);
            }
        }

        // Hapus record post (images ikut terhapus kalau FK cascade / onDelete)
        $post->delete();

        return redirect()->route('dashboard')->with('status', 'Postingan berhasil dihapus.');
    }
}
