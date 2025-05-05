<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Post;
use App\Models\User;

class LikeNotification extends Notification
{
    use Queueable;

    protected $liker;
    protected $post;

    /**
     * Create a new notification instance.
     *
     * @param User $liker
     * @param Post $post
     */
    public function __construct(User $liker, Post $post)
    {
        $this->liker = $liker;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->liker->username . ' liked your story: "' . $this->post->title . '"')
                    ->action('View Story', url(route('posts.show', $this->post->id)))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'liker_id' => $this->liker->id,
            'liker_username' => $this->liker->username,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'message' => $this->liker->username . ' liked your story: "' . $this->post->title . '"',
        ];
    }
}
