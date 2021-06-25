<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TaskStatusController extends Controller
{
    /**
     * Set how many statuses display per page.
     *
     * @var integer
     */
    private $statusesPerPage = 10;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $taskStatuses = TaskStatus::paginate($this->statusesPerPage);
        return view('task_status.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_status.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskStatusRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskStatusRequest $request)
    {
        $data = $request->validated();

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();

        flash(__('messages.task_status.create.success'))->success();

        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    // public function show(TaskStatus $taskStatus)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\View\View
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskStatusRequest  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $data = $request->validated();

        $taskStatus->fill($data);
        $taskStatus->save();

        flash(__('messages.task_status.update.success'))->success();

        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks->isNotEmpty()) {
            flash(__('messages.task_status.delete.fail'))->error();
        } else {
            $taskStatus->delete();
            flash(__('messages.task_status.delete.success'))->success();
        }

        return redirect()
            ->route('task_statuses.index');
    }
}
