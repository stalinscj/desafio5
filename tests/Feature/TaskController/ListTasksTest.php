<?php

namespace Tests\Feature\TaskController;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authenticated_users_can_list_tasks()
    {
        $this->signIn();

        $tasks = Task::factory(5)->create();

        $response = $this->get(route('tasks.index'))
            ->assertSuccessful()
            ->assertViewIs('tasks.index');

        foreach ($tasks as $task) {
            $response->assertSeeText(Str::limit($task->description, 70))
                ->assertSeeText($task->worker->name)
                ->assertSeeText($task->deadline->toDateString());
        }
    }

    /**
     * @test
     */
    function guests_users_cannot_list_tasks()
    {
        $this->get(route('tasks.index'))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function only_expired_tasks_can_have_a_red_background()
    {
        $this->signIn();

        Task::factory()->create();

        $this->get(route('tasks.index'))
            ->assertDontSee('table-danger');

        Task::factory()->expired()->create();

        $this->get(route('tasks.index'))
            ->assertSee('table-danger');
    }
}
