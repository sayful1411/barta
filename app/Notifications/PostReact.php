<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostReact extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Post $post)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $postUserFirstName = $notifiable->fname;
        $postUserLastName = $notifiable->lname;
        // $postUrl = route('posts.show', $this->post->uuid);

        return [
            'userName' => "$postUserFirstName $postUserLastName",
            'message' => "reacted to your post: ",
            'post' => substr($this->post->description, 0, 10) . '...',
            // 'post_url' => $postUrl
            'post_id' => $this->post->uuid,
            'username' => $notifiable->username
        ];
    }
}
