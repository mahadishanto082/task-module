@extends('components.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task Modular App</div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Create Multiple Tasks Form -->
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div id="tasks-wrapper">
                            <div class="task-row mb-3">
                                <input type="text" name="tasks[0][title]" placeholder="Title" class="form-control mb-1" required>
                                <textarea name="tasks[0][description]" placeholder="Description" class="form-control"></textarea>
                            </div>
                        </div>

                        <button type="button" id="add-task" class="btn btn-secondary mb-3">Add Another Task</button>
                        <button type="submit" class="btn btn-primary mb-3">Save All Tasks</button>
                    </form>

                    <!-- Task List -->
                    @php
                        $tasks = DB::table('tasks')->orderBy('created_at', 'desc')->get();
                    @endphp
                    @if($tasks->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->id }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>
                                            @if($task->is_completed)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-danger">Incomplete</span>
                                            @endif
                                        </td>
                                        <td style="display:flex; gap:5px;">
                                            <!-- Toggle Status -->
                                            <form method="POST" action="{{ route('tasks.status', $task->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $task->is_completed ? 'btn-warning' : 'btn-info' }}">
                                                    {{ $task->is_completed ? 'Uncheck' : 'Check' }}
                                                </button>
                                            </form>

                                            <!-- Delete Task -->
                                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h5>No tasks created yet!!!</h5>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS for Repeater Field -->
<script>
let taskIndex = 1;
document.getElementById('add-task').addEventListener('click', function() {
    const wrapper = document.getElementById('tasks-wrapper');
    const row = document.createElement('div');
    row.classList.add('task-row', 'mb-3');
    row.innerHTML = `
        <input type="text" name="tasks[${taskIndex}][title]" placeholder="Title" class="form-control mb-1" required>
        <textarea name="tasks[${taskIndex}][description]" placeholder="Description" class="form-control"></textarea>
        <button type="button" class="btn btn-danger btn-sm mt-1 remove-task">Remove</button>
    `;
    wrapper.appendChild(row);

    // Remove button
    row.querySelector('.remove-task').addEventListener('click', function() {
        row.remove();
    });

    taskIndex++;
});
</script>

@endsection
