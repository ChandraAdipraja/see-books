<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q');

        $posts = Post::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('body', 'like', "%{$search}%")
                      ->orWhere('course', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'search'));
    }

    public function destroy(Post $post)
    {
        // kalau pakai foreign key cascade, images/comments akan ikut kehapus
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Postingan berhasil dihapus.');
    }
}
