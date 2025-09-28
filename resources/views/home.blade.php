@extends('components.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4 style="color: Blue;" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Task Modular App
                    </h4>

                    <a href="#" class="btn btn-primary mb-3">Create</a>

                    <div class="py-3">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-3">
                            
                            @if (session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                         @php
                                $tasks = \App\Models\Tasks::where('id', auth()->id())->get();
                         @endphp

                            @if ($tasks->count() > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Completed</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $task)
                                            <tr>
                                                <td>{{ $task->title }}</td>
                                                <td>{{ $task->description }}</td>
                                                <td>
                                                    @if($task->is_completed == 1)
                                                        <span class="badge bg-success">Completed</span>
                                                    @else
                                                        <span class="badge bg-danger">Incomplete</span>
                                                    @endif
                                                </td>
                                                <td style="display: flex; align-items: center; gap: 5px;">
                                                    <a class="btn btn-warning btn-sm" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                                                    <a class="btn btn-info btn-sm" href="{{ route('tasks.show', $task->id) }}">View</a>
                                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h5>No tasks created yet!!!</h5>
                            @endif

                            <a href="#" class="btn btn-link">Want to create a new to-do?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
