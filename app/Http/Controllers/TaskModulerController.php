<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskModulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only fetch tasks for the logged-in user
        $tasks = Auth::check() ? Auth::user()->tasks()->orderBy('created_at', 'desc')->get() : collect();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store newly created tasks (supports multiple tasks) in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
        ]);

        $tasksData = $request->input('tasks', []);

        foreach ($tasksData as $taskData) {
            $task = new Tasks();
            $task->user_id = Auth::id();
            $task->title = $taskData['title'];
            $task->description = $taskData['description'] ?? null;
            $task->is_completed = 0; // default incomplete
            $task->save();
        }

        return redirect()->route('tasks.index')->with('success', 'Tasks created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show($id)
    {
        $task = Tasks::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit($id)
    {
        $task = Tasks::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'nullable|boolean',
        ]);

        $task = Tasks::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $task->title = $request->title;
        $task->description = $request->description ?? null;
        $task->is_completed = $request->is_completed ?? 0;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy($id)
    {
        $task = Tasks::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle task completion status.
     */
    public function markAsCompleted($id)
    {
        $task = Tasks::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $task->is_completed = !$task->is_completed;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully.');
    }
}
