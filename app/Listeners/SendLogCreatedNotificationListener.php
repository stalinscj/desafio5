<?php

namespace App\Listeners;

use App\Events\LogCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\LogCreatedNotification;

class SendLogCreatedNotificationListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\LogCreatedEvent  $event
     * @return void
     */
    public function handle(LogCreatedEvent $event)
    {
        $notifiable = $event->log->task->author;

        $notifiable->notify(new LogCreatedNotification($event->log));
    }
}
