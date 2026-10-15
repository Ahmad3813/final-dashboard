<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Task::with(['assignee', 'addedBy']);

        if (($user->isAdmin() && !$user->isSuperAdmin()) || $user->isTester()) {
            $query->where('assigned_to', $user->id);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('user', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        $users = User::select('id', 'name', 'role')->whereIn('role', ['tester', 'qa'])->get();

        return view('tasks.create', compact('user', 'users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {

        $user = $request->user();

        $validated = $request->validated();

        $task = new Task();
        $task->name = $validated['name'];
        $task->duration_hours = $validated['duration_hours'];
        $task->assigned_to = $validated['assigned_to'];
        $task->added_by = $user->id;
        $task->comment = $validated['comment'] ?? null;
        $task->save();

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        $task = Task::with(['assignee', 'addedBy'])->findOrFail($id);

        return view('tasks.view', compact('user', 'task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = auth()->user();
        $task = Task::findOrFail($id);

        $users = User::select('id', 'name', 'role')->whereIn('role', ['tester', 'qa'])->get();

        return view('tasks.edit', compact('user', 'users', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $user = $request->user();

        $task = Task::findOrFail($id);

        $validated = $request->validated();

        if ($user->isTester()) {
            $task->update([
                'comment' => $validated['comment'] ?? null,
            ]);
        } else {
            $task->update([
                'name' => $validated['name'],
                'duration_hours' => $validated['duration_hours'],
                'assigned_to' => $validated['assigned_to'],
                'comment' => $validated['comment'] ?? null,
            ]);
        }

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
