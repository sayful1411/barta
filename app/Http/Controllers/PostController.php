<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return abort(404);
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

        $post = Post::create([
            "uuid" => (string) Str::uuid(),
            "user_id" => $userID,
            "description" => $validatedPost["barta"],
        ]);

        if ($request->hasFile('picture')) {
            $newFileName = Str::random(10) . time() . '.' . $request->file('picture')->extension();
            // Add media to the media library
            $post->addMediaFromRequest('picture')->usingFileName($newFileName)->toMediaCollection('post_image', 'post_images');
        }

        return redirect()->route("index")->with("success", "Post Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $post = Post::with('user')->where('uuid', $uuid)->firstOrFail();

        $post->incrementViewCount();

        $comments = Comment::with('user')->where('post_id', $post->id)->get();

        return view("pages.posts.single-posts", compact("post", "comments"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $post = Post::where('uuid', $uuid)->firstOrFail();

        if (auth()->user()->id != $post->user_id) {
            return to_route("index");
        }

        return view("pages.posts.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $uuid)
    {
        // dd($request->all());
        $validatedPost = $request->validated();

        $post = Post::where('uuid', $uuid)->firstOrFail();

        $post->update([
            "description" => $validatedPost["barta"]
        ]);

        if ($request->hasFile('picture')) {
            // Delete previous post image
            $post->clearMediaCollection('post_image');

            $newFileName = Str::random(10) . time() . '.' . $request->file('picture')->extension();
            // Add media to the media library
            $post->addMediaFromRequest('picture')->usingFileName($newFileName)->toMediaCollection('post_image', 'post_images');
        }

        return redirect()->back()->with("success", "Post Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $postId = $request->post_delete_id;

        $post = Post::where('id', $postId)->firstOrFail();

        if (auth()->user()->id != $post->user_id) {
            return to_route("index");
        }

        Post::where('id', $postId)->delete();

        return to_route("index")->with("success", "Post deleted");
    }
}
