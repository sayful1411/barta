<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ReactProcessed;
use App\Notifications\PostReact;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReactNotification
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
    public function handle(ReactProcessed $event): void
    {
        // dd($event->post);
        $userId = $event->post->user_id;
        $user = User::find($userId);
        $post = $event->post;

        // $postUser = $post->user;

        $user->notify(new PostReact($post));
    }
}
