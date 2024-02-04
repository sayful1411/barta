<?php

namespace App\Http\Controllers;

use App\Events\CommentProcessed;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postID)
    {
        $userID = auth()->user()->id;
        $validated = $request->validate([
            "comment" => ["required", "string", "max:200"],
        ]);

        $comment = Comment::create([
            'user_id' => $userID,
            'post_id' => $postID,
            'description' => $validated['comment']
        ]);

        event(new CommentProcessed($comment));

        $post = Post::where('id', $postID)->firstOrFail();

        return redirect()->route('posts.show', $post->uuid)->with('success', 'Comment Added');
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

        return redirect()->route('posts.show', $post->uuid)->with('success', 'Comment updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        $comment = Comment::where('id', $comment->id)->where('post_id', $post->id)->firstOrFail();

        if (auth()->user()->id != $comment->user_id) {
            return abort(401); // unauthorized
        }

        $comment->delete();

        $post = Post::where('id', $post->id)->firstOrFail();

        return redirect()->route('posts.show', $post->uuid)->with("success", "Comment deleted");
    }
}
