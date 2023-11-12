<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function indexPage()
    {
        $posts = DB::table('posts')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'users.fname as user_fname', 'users.lname as user_lname', 'users.username as user_username','users.email as user_email')
                ->orderBy('id','desc')
                ->get();

        $posts = $posts->map(function ($post) {
            $post->created_at = Carbon::parse($post->created_at);
            return $post;
        });

        return view("index", compact("posts"));
    }
}
