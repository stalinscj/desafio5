<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory(20)
            ->sequence(
                ['deadline' => today()->subDay()],
                ['deadline' => today()],
                ['deadline' => today()->addDay()]
            )
            ->create();
    }
}
