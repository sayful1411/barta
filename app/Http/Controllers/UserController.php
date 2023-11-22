<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index($username){
        $user = DB::table("users")->where("username", $username)->first();

        if (empty($user)) {
            return abort(404);
        }

        $posts = DB::table('posts')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'users.fname as user_fname', 'users.lname as user_lname', 'users.username as user_username','users.email as user_email')
                ->where('posts.user_id', $user->id)
                ->orderBy('id','desc')
                ->get();

        $posts = $posts->map(function ($post) {
            $post->created_at = Carbon::parse($post->created_at);
            return $post;
        });

        return view("pages.profiles.user-profile", compact("user", "posts"));
    }

}
