<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000'
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        return back()->with('status', 'Komentar dikirim!');
    }
        public function destroy(Post $post, Comment $comment)
    {
        $user = auth()->user();

        // Pastikan komentar memang milik post ini
        if ($comment->post_id !== $post->id) {
            abort(404);
        }

        // Hanya pemilik komentar atau admin yang boleh hapus
        if ($comment->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Kamu tidak punya izin menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('status', 'Komentar berhasil dihapus.');
    }
}
