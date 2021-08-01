@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Task List</div>

                <div class="card-body">
                    
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Worker</th>
                                <th>Deadline</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                               <tr class="{{ $task->is_expired ? 'table-danger' : '' }}">
                                    <td class="align-middle">{{ Str::limit($task->description, 70) }}</td>
                                    <td class="align-middle">{{ $task->worker->name }}</td>
                                    <td class="align-middle">{{ $task->deadline->toDateString() }}</td>
                                    <td class="align-middle">
                                        @if ($task->worker->is(auth()->user()))
                                            <a href="#" class="btn btn-sm btn-success" title="See Details">
                                                S
                                            </a>
                                        @endif

                                        @if ($task->author->is(auth()->user()))
                                            <a href="#" class="btn btn-sm btn-info my-1" title="Edit">
                                                E
                                            </a>
                                            
                                            <a href="#" class="btn btn-sm btn-danger" title="Delete">
                                                X
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No data available, please <a href="{{ route('tasks.create') }}">Create</a> some tasks.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex">
                        <div class="mx-auto">
                            {{ $tasks->links() }}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection