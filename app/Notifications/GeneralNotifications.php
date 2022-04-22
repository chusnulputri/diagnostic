<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotifications extends Notification
{
    use Queueable;

    protected $details;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        $this->details = $detail;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->details['title'] ?? '( Tanpa judul )',
            'message' => $this->details['message'] ?? '( Tanpa pesan )',
            'url' => $this->details['url'] ?? null,
            'type' => $this->details['data'][0] ?? null,
        ];
    }
}
