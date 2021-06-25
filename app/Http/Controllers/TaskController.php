<?php

namespace App\Http\Controllers;

use App\Models\{Task, TaskStatus, User, Label, LabelTask};
use App\Http\Requests\{StoreTaskRequest, UpdateTaskRequest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\{QueryBuilder, AllowedFilter};

class TaskController extends Controller
{
    /**
     * Set how many tasks display per page.
     *
     * @var integer
     */
    private $tasksPerPage = 10;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $taskStatuses = TaskStatus::all()
            ->mapWithKeys(fn($status) => [$status->id => $status->name])
            ->all();
        $authors = User::all()
            ->mapWithKeys(fn($user) => [$user->id => $user->name])
            ->all();
        $executors = $authors;
        $searchParams = $request->input('filter');

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->paginate($this->tasksPerPage);

        return view('task.index', compact('tasks', 'taskStatuses', 'authors', 'executors', 'searchParams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
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
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = Auth::user()->id;
        $task->save();

        if (isset($data['labels'][0])) {
            $task->labels()->sync($data['labels']);
        }

        flash(__('messages.task.create.success'))->success();

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\View\View
     */
    public function edit(Task $task)
    {
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
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();

        flash(__('messages.task.delete.success'))->success();
        return redirect()
            ->route('tasks.index');
    }
}
