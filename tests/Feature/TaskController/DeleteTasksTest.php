<?php

namespace Tests\Feature\TaskController;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_task_can_be_deleted_by_its_author()
    {
        $user = $this->signIn();

        $task = Task::factory()->create(['author_id' => $user->id]);

        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseCount('tasks', 0);
    }

    /**
     * @test
     */
    public function when_a_task_is_deleted_its_logs_are_also_deleted()
    {
        $user = $this->signIn();

        $task = Task::factory()
            ->hasLogs(2)
            ->create(['author_id' => $user->id]);

        $this->delete(route('tasks.destroy', $task));

        $this->assertDatabaseCount('tasks', 0);
        $this->assertDatabaseCount('logs', 0);
    }

    /**
     * @test
     */
    public function a_task_cannot_be_deleted_by_an_user_who_is_not_its_author()
    {
        $this->signIn();

        $task = Task::factory()->create();

        $this->delete(route('tasks.destroy', $task))
            ->assertForbidden();

        $this->assertDatabaseCount('tasks', 1);
    }

    /**
     * @test
     */
    public function a_task_cannot_be_deleted_by_guests_users()
    {
        $task = Task::factory()->create();

        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('tasks', 1);
    }
}
