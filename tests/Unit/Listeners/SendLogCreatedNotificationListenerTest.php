<?php

namespace Tests\Unit\Listeners;

use App\Models\Log;
use Tests\TestCase;
use App\Events\LogCreatedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LogCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendLogCreatedNotificationListenerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_notification_is_sent_to_task_author_when_a_log_is_created()
    {
        Notification::fake();

        $log = Log::factory()->create();

        LogCreatedEvent::dispatch($log);

        Notification::assertSentTo(
            $log->task->author, 
            LogCreatedNotification::class, 
            function ($logCreatedNotification, $channels) use ($log) {
                $this->assertContains('mail', $channels);
                
                $this->assertTrue($logCreatedNotification->log->is($log));
                
                return true;
            }
        );
        
    }
}
