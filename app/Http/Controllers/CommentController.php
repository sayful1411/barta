<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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

        DB::table('comments')->insert([
            'user_id' => $userID,
            'post_id' => $postID,
            'description' => $validated['comment'],
            'created_at' => now(),
            'updated_at' => now(),
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
        $comment = DB::table('comments')
            ->where('id', $commentID)
            ->where('post_id', $postID)
            ->first();

        if (!$comment) {
            return abort(404); // Comment not found
        }

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

        $post = DB::table('posts')->where('id', $postID)->first();

        DB::table('comments')
            ->where('id', $commentID)
            ->where('post_id', $postID)
            ->update([
                'description' => $validated['comment'],
                'updated_at' => now(),
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

        $comment = DB::table('comments')
            ->where('id', $commentID)
            ->where('post_id', $postID)
            ->first();

        if (!$comment) {
            return abort(404); // Comment not found
        }

        if (auth()->user()->id != $comment->user_id) {
            return abort(401); // unauthorized
        }

        DB::table("comments")->where("id", $commentID)
            ->where('post_id', $postID)
            ->delete();

        return redirect()->back()->with("success", "comment deleted");
    }
}
