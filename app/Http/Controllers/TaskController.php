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
        $tasks = Auth::user()->tasks;
        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->toArray();
        return Inertia::render('Tasks/Create', [
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
            'status' => 'pending',
            'due_date' => $request->due_date,
            'created_by' => Auth::user()->id,
        ]);

        if ($request->has('users') && is_array($request->users)) {
            $task->users()->attach($request->users);
        }

        return redirect()->route('dashboard');
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $tasks = Task::where('created_by', Auth::user()->id)->get();
        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        // Verifica se a tarefa pertence ao usuário autenticado
        if ($task->created_by !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Você não tem permissão para editar esta tarefa.');
        }

        // Retorna a view de edição com os dados da tarefa
        return Inertia::render('Tasks/Edit', [
            'task' => $task
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    // TaskController.php
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Verifica se a tarefa pertence ao usuário autenticado
        if ($task->created_by !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Você não tem permissão para atualizar esta tarefa.');
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        // Retorna a resposta de sucesso
        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Verifica se a tarefa pertence ao usuário autenticado
        if ($task->created_by !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Você não tem permissão para excluir esta tarefa.');
        }

        $task->delete();  // Deleta a tarefa

        return redirect()->route('tasks.index')->with('success', 'Tarefa excluída com sucesso!');
    }
}
