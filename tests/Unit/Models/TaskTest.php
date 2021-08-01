<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_task_belongs_to_worker()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(User::class, $task->worker);
    }

    /**
     * @test
     */
    public function a_task_belongs_to_author()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(User::class, $task->author);
    }

    /**
     * @test
     */
    public function a_task_has_an_expired_status_depending_on_its_deadline()
    {
        $task = Task::factory()->make();

        $this->assertEquals(false, $task->isExpired());
        $this->assertEquals(false, $task->is_expired);
        
        $task = Task::factory()->expired()->make();

        $this->assertEquals(true, $task->isExpired());
        $this->assertEquals(true, $task->is_expired);
    }
}
