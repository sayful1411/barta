<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postID)
    {
        $userID = auth()->user()->id;
        $validated = $request->validate([
            "comment" => ["required", "string", "max:200"],
        ]);

        Comment::create([
            'user_id' => $userID,
            'post_id' => $postID,
            'description' => $validated['comment']
        ]);

        return redirect()->back()->with('success', 'Comment Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($postID, $commentID)
    {
        $comment = Comment::where('id', $commentID)->where('post_id', $postID)->firstOrFail();

        if (auth()->user()->id != $comment->user_id) {
            return abort(401); // unauthorized
        }

        return view('pages.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $postID, $commentID)
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:200'],
        ]);

        $post = Post::where('id', $postID)->firstOrFail();

        Comment::where('id', $commentID)
                ->where('post_id', $postID)
                ->update([
                    'description' => $validated['comment']
                ]);

        $postShowRoute = route('posts.show', $post->uuid);

        return redirect($postShowRoute)->with('success', 'comment updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $postID = $request->post_delete_id;
        $commentID = $request->comment_delete_id;

        $comment = Comment::where('id', $commentID)->where('post_id', $postID)->firstOrFail();
        if (auth()->user()->id != $comment->user_id) {
            return abort(401); // unauthorized
        }

        Comment::where("id", $commentID)->where('post_id', $postID)->delete();

        return redirect()->back()->with("success", "comment deleted");
    }
}
