@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task Detail</div>

                <div class="card-body">
                    
                    <div class="font-weight-bold">Author:</div>
                    <div>{{ $task->author->name }} - {{ $task->author->email }}</div>

                    <div class="font-weight-bold mt-2">Worker:</div>
                    <div>{{ $task->worker->name }} - {{ $task->worker->email }}</div>

                    <div class="font-weight-bold mt-2">Deadline:</div>
                    <div>{{ $task->deadline->toDateString() }}</div>
                    
                    <div class="font-weight-bold mt-2">Description:</div>
                    <div>{{ $task->description }}</div>

                    <hr>
                        @forelse ($task->logs as $log)
                            <div class="card mb-2">
                                <div class="card-header">{{ $log->user->name }} at {{ $log->created_at }}</div>

                                <div class="card-body">
                                    <p>{{ $log->comment }}</p>
                                </div>

                            </div>
                        @empty
                            <div class="text-center">
                                This task has no logs.
                            </div>
                        @endforelse
                    <hr>

                    <form method="POST" action="{{ route('tasks.logs.store', $task) }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-12">
                                <textarea id="comment" name="comment" rows="3" required autofocus
                                    class="form-control @error('comment') is-invalid @enderror"
                                    placeholder="Comment..."
                                    >{{ old('comment') }}</textarea>

                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group d-flex">
                            <button type="submit" class="btn btn-primary ml-auto">
                                Add Log
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
