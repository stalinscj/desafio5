<?php

namespace Tests\Unit\Models;

use App\Models\Log;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_log_belongs_to_task()
    {
        $log = Log::factory()->create();

        $this->assertInstanceOf(Task::class, $log->task);
    }

    /**
     * @test
     */
    public function a_log_belongs_to_user()
    {
        $log = Log::factory()->create();

        $this->assertInstanceOf(User::class, $log->user);
    }
}
