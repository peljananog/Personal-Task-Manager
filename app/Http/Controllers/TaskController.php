<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
        ]);

        Task::create($request->all());

        return redirect()->back()->with('success', 'Task added successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
}