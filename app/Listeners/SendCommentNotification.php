<?php

namespace App\Listeners;

use App\Events\CommentProcessed;
use App\Mail\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostComment;
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

        // $postUserEmail = $post->user->email;

        // Mail::to($postUserEmail)->send(new Comment($user, $post));

        $postUser = $post->user;
        $comment = $event->comment->description;

        $postUser->notify(new PostComment($user, $post, $comment));
    }
}
