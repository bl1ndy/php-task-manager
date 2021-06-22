<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate();
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('task_create');

        $task = new Task();
        $taskStatuses = TaskStatus::all()
            ->mapWithKeys(fn($status) => [$status->id => $status->name])
            ->all();
        $executors = User::all()
            ->mapWithKeys(fn($user) => [$user->id => $user->name])
            ->all();

        return view('task.create', compact('task', 'taskStatuses', 'executors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks,name,NULL,id,deleted_at,NULL',
            'status_id' => 'required',
            'description' => '',
            'assigned_to_id' => ''
        ]);

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = Auth::user()->id;
        $task->save();

        flash(__('messages.task.create.success'))->success();

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $statusName = TaskStatus::find($task->status_id)->name;
        return view('task.show', compact('task', 'statusName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        Gate::authorize('task_update');

        $taskStatuses = TaskStatus::all()
            ->mapWithKeys(fn($status) => [$status->id => $status->name])
            ->all();
        $executors = User::all()
            ->mapWithKeys(fn($user) => [$user->id => $user->name])
            ->all();

        return view('task.edit', compact('task', 'taskStatuses', 'executors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks,name,' . $task->id . ',id,deleted_at,NULL',
            'status_id' => 'required',
            'description' => '',
            'assigned_to_id' => ''
        ]);

        $task->fill($data);
        $task->save();

        flash(__('messages.task.update.success'))->success();

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        flash(__('messages.task.delete.success'))->success();
        return redirect()
            ->route('tasks.index');
    }
}
