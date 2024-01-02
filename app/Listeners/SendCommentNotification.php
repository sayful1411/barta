<?php

namespace App\Listeners;

use App\Events\CommentProcessed;
use App\Mail\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCommentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentProcessed $event): void
    {
        $userId = $event->comment->user_id;
        $postId = $event->comment->post_id;
        $user = User::find($userId);
        $post = Post::with('user')->find($postId);

        $postUser = $post->user->email;

        // dd($user->fname . ' ' . $user->lname);
        // dd(route('posts.show', $post->uuid));

        Mail::to($postUser)->send(new Comment($user, $post));
    }
}
