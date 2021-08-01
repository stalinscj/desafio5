@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Task</div>

                <div class="card-body">
                    @include('tasks._form', ['method'=>'POST', 'action'=>'store'])
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
