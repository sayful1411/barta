<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostComment extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public Post $post,
        public $comment,
    ){}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $postUserFirstName = $this->user->fname;
        $postUserLastName = $this->user->lname;
        $postUrl = route('posts.show', $this->post->uuid);

        return (new MailMessage)
                    ->subject("$postUserFirstName $postUserLastName commented on your post")
                    ->greeting("Hello $notifiable->fname")
                    ->line("$postUserFirstName $postUserLastName commented on your post: " . substr($this->comment, 0, 10) . '...')
                    ->action('View Post', $postUrl)
                    ->line('Thank you for using ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $postUserFirstName = $this->user->fname;
        $postUserLastName = $this->user->lname;
        $postUrl = route('posts.show', $this->post->uuid);

        return [
            'message' => "$postUserFirstName $postUserLastName commented on your post: " . substr($this->comment, 0, 10) . '...',
            'post_url' => $postUrl
        ];
    }
}
