<?php

namespace Tests\Feature\TaskController;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_task_can_be_updated_by_its_author()
    {
        $user = $this->signIn();

        $task = Task::factory()->create(['author_id' => $user->id]);

        $this->get(route('tasks.edit', $task))
            ->assertSuccessful()
            ->assertViewIs('tasks.edit');

        $attributes = Task::factory()->raw(['author_id' => $user->id]);

        $this->put(route('tasks.update', $task), $attributes)
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseCount('tasks', 1);

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /**
     * @test
     */
    public function a_task_cannot_be_updated_by_an_user_who_is_not_its_author()
    {
        $this->signIn();

        $task = Task::factory()->create();

        $this->get(route('tasks.edit', $task))
            ->assertForbidden();

        $attributes = Task::factory()->raw();

        $this->put(route('tasks.update', $task), $attributes)
            ->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['worker_id' => $attributes['worker_id']]);
    }

    /**
     * @test
     */
    public function a_task_cannot_be_updated_by_guests_users()
    {
        $task = Task::factory()->create();

        $this->get(route('tasks.edit', $task))
            ->assertRedirect(route('login'));

        $attributes = Task::factory()->raw();

        $this->put(route('tasks.update', $task), $attributes)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tasks', ['worker_id' => $attributes['worker_id']]);
    }
}
