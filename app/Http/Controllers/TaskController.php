<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();

        $users = User::all();

        return view('tasks.create', compact('task', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TaskRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        toast()->success('Task Created!');

        return redirect()->route('tasks.create');
    }
}
