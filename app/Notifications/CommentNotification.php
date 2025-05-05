<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Post;
use App\Models\User;

class CommentNotification extends Notification
{
    use Queueable;

    protected $commenter;
    protected $post;
    protected $commentContent;

    /**
     * Create a new notification instance.
     *
     * @param User $commenter
     * @param Post $post
     * @param string $commentContent
     */
    public function __construct(User $commenter, Post $post, $commentContent)
    {
        $this->commenter = $commenter;
        $this->post = $post;
        $this->commentContent = $commentContent;
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
                    ->line($this->commenter->username . ' commented on your story: "' . $this->post->title . '"')
                    ->line('Comment: "' . $this->commentContent . '"')
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
            'commenter_id' => $this->commenter->id,
            'commenter_username' => $this->commenter->username,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_content' => $this->commentContent,
            'message' => $this->commenter->username . ' commented on your story: "' . $this->post->title . '"',
        ];
    }
}
