<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Task;
use App\Events\LogCreatedEvent;
use App\Http\Requests\TaskLogRequest;

class TaskLogController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskLogRequest  $request
     * @param  \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function store(TaskLogRequest $request, Task $task)
    {
        $this->authorize('create', [Log::class, $task]);

        $log = $task->logs()
            ->create([
                'user_id' => auth()->id(),
                'comment' => $request->comment
            ]);

        LogCreatedEvent::dispatch($log);

        toast()->success('Log Created!');

        return redirect()->route('tasks.show', $task);
    }
}
