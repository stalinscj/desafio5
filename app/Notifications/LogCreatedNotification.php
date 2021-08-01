<?php

namespace App\Notifications;

use App\Models\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LogCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The log created
     *
     * @var \App\Models\Log
     */
    public $log;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->line("A new log has been created by {$this->log->user->name} in his task.")
                    ->action('Go to Task List', url(route('tasks.index')));
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
            //
        ];
    }
}
