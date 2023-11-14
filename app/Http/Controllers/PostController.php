<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $validatedPost = $request->validated();
        $userID = auth()->user()->id;

        DB::table("posts")->insert([
            "uuid" => (string) Str::uuid(),
            "user_id" => $userID,
            "description" => $validatedPost["barta"],
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        return redirect()->route("index")->with("success", "Post Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $post = DB::table("posts")
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.fname as user_fname', 'users.lname as user_lname', 'users.username as user_username', 'users.email as user_email')
            ->where("uuid", $uuid)
            ->first();

        $post->created_at = Carbon::parse($post->created_at);

        if (!$post) {
            return redirect()->back()->with("error", "Post Not Found");
        }

        return view("pages.posts.single-posts", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $post = DB::table("posts")->where("uuid", $uuid)->first();

        $post->created_at = Carbon::parse($post->created_at);

        if(auth()->user()->id != $post->user_id) {
            return to_route("index");
        }

        if (!$post) {
            return redirect()->back()->with("error", "Post Not Found");
        }

        return view("pages.posts.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $uuid)
    {
        $validatedPost = $request->validated();

        DB::table("posts")
            ->where("uuid", $uuid)
            ->update([
                "description" => $validatedPost["barta"],
                "updated_at" => now(),
            ]);

        return redirect()->back()->with("success", "Post Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
