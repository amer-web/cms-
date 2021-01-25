<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentForOwnerPostNotify extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;
    protected $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $arr = ['database', 'broadcast'];
        if ($notifiable->receive_email == 1) {
            $arr[] = 'mail';
        }
        return $arr;
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
            ->line('the new comment from ' . $this->comment->name)
            ->action('Notification Action', route('post.show', $this->comment->post->slug))
            ->line('Thank you for using cms amer');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'name' => 'A New Comment For Post ('. $this->comment->post->title .') From : '. $this->comment->name ,
            'created_at' => $this->comment->created_at->format('d M y, h:i a'),
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'name' => 'A New Comment For Post ('. $this->comment->post->title .') From : '. $this->comment->name ,
                'created_at' => $this->comment->created_at->format('d M y, h:i a'),
            ]
        ]);
    }
}
