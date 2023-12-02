<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class UserController extends Controller
{

    public function index($username)
    {
        $user = User::where("username", $username)->firstOrFail();
        $posts = Post::with(['user', 'media', 'comments'])->where('user_id', $user->id)->orderByDesc('created_at')->get();

        return view("pages.profiles.user-profile", compact("user", "posts"));
    }

}
