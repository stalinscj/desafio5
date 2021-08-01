<?php

namespace Tests\Feature\TaskController;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authenticated_users_can_create_tasks()
    {
        $user = $this->signIn();

        $this->get(route('tasks.create'))
            ->assertSuccessful()
            ->assertViewIs('tasks.create');

        $attributes = Task::factory()->raw(['author_id' => $user->id]);

        $this->post(route('tasks.store'), $attributes)
            ->assertRedirect(route('tasks.create'));

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /**
     * @test
     */
    function guests_users_cannot_create_tasks()
    {
        $this->get(route('tasks.create'))
            ->assertRedirect(route('login'));
        
        $attributes = Task::factory()->raw();

        $this->post(route('tasks.store', $attributes))
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('tasks', 0);
    }

    /**
     * @test
     */
    public function the_worker_id_field_is_validated()
    {
        $this->signIn();

        // The worker_id is required
        $attributes = Task::factory()->raw(['worker_id' => null]);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('worker_id');

        // The worker_id must be an integer
        $attributes = Task::factory()->raw(['worker_id' => 'NaN']);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('worker_id');

        // The worker_id must exist in the users table
        $attributes = Task::factory()->raw(['worker_id' => 999]);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('worker_id');

        $this->assertDatabaseCount('tasks', 0);
    }

    /**
     * @test
     */
    public function the_deadline_field_is_validated()
    {
        $this->signIn();

        // The deadline is required
        $attributes = Task::factory()->raw(['deadline' => null]);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('deadline');

        // The deadline must be a date
        $attributes = Task::factory()->raw(['deadline' => 'invalid-date']);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('deadline');
        
        // The deadline must be after yesterday
        $attributes = Task::factory()->raw(['deadline' => today()->subDay()]);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('deadline');

        $this->assertDatabaseCount('tasks', 0);
    }

    /**
     * @test
     */
    public function the_description_field_is_validated()
    {
        $this->signIn();

        // The description is required
        $attributes = Task::factory()->raw(['description' => null]);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('description');

        // The description may not be greater than 1000 chars
        $attributes = Task::factory()->raw(['description' => Str::random(1001)]);

        $this->post(route('tasks.store'), $attributes)
            ->assertSessionHasErrors('description');

        $this->assertDatabaseCount('tasks', 0);
    }
}
