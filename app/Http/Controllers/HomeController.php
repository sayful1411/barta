<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Post;

class HomeController extends Controller
{
    public function indexPage()
    {
        $posts = Post::with('user', 'comments')->get();

        return view("index", compact("posts"));
    }
}
