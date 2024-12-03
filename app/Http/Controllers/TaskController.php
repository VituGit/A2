<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->toArray();
        return Inertia::render('Dashboard', [
            'users' => $users,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => "pending",
            'due_date' => $request->due_date,
            'created_by' => Auth::user()->id,
        ]);

        if ($request->has('users') && is_array($request->users)) {
            $task->users()->attach($request->users);
        }

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
