<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();

        // 5 user terbaru join
        $latestUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 5 postingan terbaru
        $latestPosts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPosts',
            'latestUsers',
            'latestPosts',
        ));
    }
}