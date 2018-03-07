<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * Get list of Posts created by user.
     */
    public function posts()
    {
        $posts = auth()->user()
            ->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('post.userPosts', compact('posts'));
    }
}
