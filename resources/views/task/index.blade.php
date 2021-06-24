@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('views.task.index.tasks')</h1>
    <div class="d-flex">
        <div>
            {{ Form::open(['url' => route('tasks.index'), 'method' => 'GET', 'class' => 'form-inline']) }}
                {{ Form::select('filter[status_id]', $taskStatuses, $searchParams['status_id'] ?? null, ['placeholder' => __('models.task.status'), 'class' => 'form-control mr-2']) }}
                {{ Form::select('filter[created_by_id]', $authors, $searchParams['created_by_id'] ?? null, ['placeholder' => __('models.task.author'), 'class' => 'form-control mr-2']) }}
                {{ Form::select('filter[assigned_to_id]', $executors, $searchParams['assigned_to_id'] ?? null, ['placeholder' => __('models.task.executor'), 'class' => 'form-control mr-2']) }}
                {{ Form::submit(__('views.task.index.buttons.submit'), ['class' => 'btn btn-outline-primary mr-2']) }}
            {{ Form::close() }}
        </div>
        @can('task_create')
            <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">@lang('views.task.index.buttons.create')</a>
        @endcan

    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>@lang('models.task.id')</th>
                <th>@lang('models.task.status')</th>
                <th>@lang('models.task.name')</th>
                <th>@lang('models.task.author')</th>
                <th>@lang('models.task.executor')</th>
                <th>@lang('models.task_status.created_at')</th>
                @can('task_create')
                    <th>@lang('views.task.index.actions')</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td>
                <td><a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a></td>
                <td>{{ $task->author->name }}</td>
                <td>{{ $task->executor->name }}</td>
                <td>{{ $task->created_at }}</td>
                @can('task_update')  
                    <td>
                        @can('task_destroy', $task) 
                            <a href="{{ route('tasks.destroy', $task) }}" data-confirm="Вы уверены?" data-method="delete" class="text-danger">@lang('views.task.index.buttons.delete')</a>
                        @endcan
                        <a href="{{ route('tasks.edit', $task) }}">@lang('views.task.index.buttons.edit')</a>
                    </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
@endsection