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

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
