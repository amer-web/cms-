<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostForAdminNotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $post;
    public function __construct($post)
    {
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
        return ['database', 'broadcast'];
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
            'name' =>  'A New Post ('. $this->post->title .') From : '. $this->post->user->username ,
            'created_at' => $this->post->created_at->format('d M y, h:i a'),
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'name' =>  'A New Post ('. $this->post->title .') From : '. $this->post->user->username ,
                'created_at' => $this->post->created_at->format('d M y, h:i a'),
            ]
        ]);
    }
}
