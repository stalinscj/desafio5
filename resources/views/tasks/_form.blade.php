<form method="POST" action="{{ route("tasks.$action", $task) }}">
    @csrf
    @method($method)

    <div class="form-group row">
        <label for="deadline" class="col-md-4 col-form-label text-md-right">Deadline</label>

        <div class="col-md-6">
            <input id="deadline" type="date" name="deadline" value="{{ old('deadline', optional($task->deadline)->toDateString()) }}" 
                class="form-control @error('deadline') is-invalid @enderror" required autofocus>

            @error('deadline')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="form-group row">
        <label for="worker_id" class="col-md-4 col-form-label text-md-right">Worker</label>

        <div class="col-md-6">
            <select id="worker_id" name="worker_id" required 
                class="form-control @error('worker_id') is-invalid @enderror">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('worker_id', $task->worker_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            @error('worker_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

        <div class="col-md-6">
            <textarea id="description" name="description" rows="10" required
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Description..."
                >{{ old('description', $task->description) }}</textarea>

            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Save
            </button>
        </div>
    </div>

</form>