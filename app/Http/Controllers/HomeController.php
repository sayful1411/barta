<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function indexPage()
    {
        // $posts = DB::table('posts')
        //         ->join('users', 'posts.user_id', '=', 'users.id')
        //         ->select('posts.*', 'users.fname as user_fname', 'users.lname as user_lname', 'users.username as user_username','users.email as user_email')
        //         ->orderBy('id','desc')
        //         ->get();

        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            ->select(
                'posts.*',
                'users.fname as user_fname',
                'users.lname as user_lname',
                'users.username as user_username',
                'users.email as user_email',
                DB::raw('COUNT(comments.id) as comment_count')
            )
            ->groupBy(
                'posts.id',
                'posts.uuid',
                'posts.user_id',
                'posts.description',
                'posts.view_count',
                'posts.image',
                'posts.created_at',
                'posts.updated_at',
                'users.fname',
                'users.lname',
                'users.username',
                'users.email'
            )
            ->orderBy('posts.id', 'desc')
            ->get();

        $posts = $posts->map(function ($post) {
            $post->created_at = Carbon::parse($post->created_at);
            return $post;
        });

        return view("index", compact("posts"));
    }
}
