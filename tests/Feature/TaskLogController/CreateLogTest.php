<?php

namespace Tests\Feature\TaskLogController;

use App\Models\Log;
use Tests\TestCase;
use App\Models\Task;
use Illuminate\Support\Str;
use App\Events\LogCreatedEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateLogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authenticated_user_can_create_logs_for_the_tasks_assigned_to_him()
    {
        Event::fake([LogCreatedEvent::class]);
        
        $user = $this->signIn();

        $task = Task::factory()->create(['worker_id' => $user->id]);

        $attributes = Log::factory()->raw([
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        $this->post(route('tasks.logs.store', $task), $attributes)
            ->assertRedirect(route('tasks.show', $task));

        $this->assertDatabaseHas('logs', $attributes);
    }

    /**
     * @test
     */
    function an_event_is_fired_when_a_log_is_created()
    {
        Event::fake([LogCreatedEvent::class]);

        $user = $this->signIn();

        $task = Task::factory()->create(['worker_id' => $user->id]);

        $attributes = Log::factory()->raw();

        $this->post(route('tasks.logs.store', $task), $attributes);

        Event::assertDispatched(LogCreatedEvent::class, function ($logCredtedEvent) {
            
            $this->assertInstanceOf(Log::class, $logCredtedEvent->log);
            
            $this->assertTrue(Log::first()->is($logCredtedEvent->log));

            return true;
        });
    }

    /**
     * @test
     */
    public function guests_users_cannot_create_logs()
    {
        $task = Task::factory()->create();

        $attributes = Log::factory()->raw();

        $this->post(route('tasks.logs.store', $task), $attributes)
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('logs', 0);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_create_logs_for_the_tasks_not_assigned_to_him()
    {
        $this->signIn();

        $task = Task::factory()->create();

        $attributes = Log::factory()->raw();

        $this->post(route('tasks.logs.store', $task), $attributes)
            ->assertForbidden();

        $this->assertDatabaseCount('logs', 0);
    }

    /**
     * @test
     */
    public function the_comment_field_is_validated()
    {
        $user = $this->signIn();

        $task = Task::factory()->create(['worker_id' => $user->id]);

        // The comment is required
        $attributes = Log::factory()->raw(['comment' => null]);

        $this->post(route('tasks.logs.store', $task), $attributes)
            ->assertSessionHasErrors('comment');

        // The comment may not be greater than 1000 chars
        $attributes = Log::factory()->raw(['comment' => Str::random(1001)]);

        $this->post(route('tasks.logs.store', $task), $attributes)
            ->assertSessionHasErrors('comment');

        $this->assertDatabaseCount('logs', 0);
    }
}
