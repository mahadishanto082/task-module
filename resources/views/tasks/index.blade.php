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

                        <!-- Create Task Form -->
                        <form method="POST" action="{{ route('tasks.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mb-3">Add Task</button>
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

                                                @if ($task->is_completed)
                                                    <form method="POST" action="{{ route('tasks.status', $task->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-warning">
                                                            Uncheck
                                                        </button>
                                                    </form>

                                                @elseif (!$task->is_completed)
                                                    <form method="POST" action="{{ route('tasks.status', $task->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-info">
                                                            Check
                                                        </button>
                                                    </form>
                                                @endif

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
@endsection
