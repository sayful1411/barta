<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function indexPage()
    {
        $posts = Post::with('user.media', 'media', 'comments')->orderByDesc('created_at')->get();

        return view("index", compact("posts"));
    }
}
