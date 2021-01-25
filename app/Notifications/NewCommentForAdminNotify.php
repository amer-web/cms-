<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Broadcast;

class NewCommentForAdminNotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $comment;
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
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

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
