<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Label;
use App\Models\LabelTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        $labels = Label::all()
            ->mapWithKeys(fn($label) => [$label->id => $label->name])
            ->all();

        return view('task.create', compact('task', 'taskStatuses', 'executors', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = Auth::user()->id;
        $task->save();

        if (isset($data['labels']) && !is_null($data['labels'][0])) {
            foreach ($data['labels'] as $labelId) {
                $LabelByTask = new LabelTask();
                $LabelByTask->fill([
                    'label_id' => $labelId,
                    'task_id' => $task->id
                ]);
                $LabelByTask->save();
            }
        }

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
        $labels = $task->labels;
        return view('task.show', compact('task', 'statusName', 'labels'));
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
        $labels = Label::all()
            ->mapWithKeys(fn($label) => [$label->id => $label->name])
            ->all();
        $selectedLabels = collect($task->labels)
            ->map(fn($label) => $label->id)
            ->all();

        return view('task.edit', compact('task', 'taskStatuses', 'executors', 'labels', 'selectedLabels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->fill($data);
        $task->save();
        LabelTask::where('task_id', $task->id)->delete();

        if (isset($data['labels']) && !is_null($data['labels'][0])) {
            foreach ($data['labels'] as $labelId) {
                $LabelByTask = new LabelTask();
                $LabelByTask->fill([
                    'label_id' => $labelId,
                    'task_id' => $task->id
                ]);
                $LabelByTask->save();
            }
        }

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
