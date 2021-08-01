<?php

namespace Tests\Feature\TaskController;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authenticated_user_can_see_the_details_of_the_tasks_assigned_to_him()
    {
        $user = $this->signIn();

        $task = Task::factory()
            ->create(['worker_id' => $user->id]);

        $this->get(route('tasks.show', $task))
            ->assertSuccessful()
            ->assertViewIs('tasks.show')
            ->assertSeeText($task->author->name)
            ->assertSeeText($task->author->email)
            ->assertSeeText($task->worker->name)
            ->assertSeeText($task->worker->email)
            ->assertSeeText($task->deadline->toDateString())
            ->assertSeeText($task->description);
    }

    /**
     * @test
     */
    public function guests_users_cannot_see_the_details_of_the_tasks()
    {
        $task = Task::factory()->create();

        $this->get(route('tasks.show', $task))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_see_the_details_of_the_tasks_not_assigned_to_him()
    {
        $this->signIn();

        $task = Task::factory()->create();

        $this->get(route('tasks.show', $task))
            ->assertForbidden();
    }
}
