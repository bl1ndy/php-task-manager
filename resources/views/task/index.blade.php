@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('views.task.index.tasks')</h1>

    @can('task_create')
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">@lang('views.task.index.buttons.create')</a>
    @endcan

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
                <td>{{ $task->name }}</td>
                <td>{{ $task->author }}</td>
                <td>{{ $task->executor }}</td>
                <td>{{ $task->created_at }}</td>
                @can('task_create')
                    <td>
                        <a class="text-danger" href="" data-confirm="Вы уверены?" data-method="delete">@lang('views.task.index.buttons.delete')</a>
                        <a href="{{ route('tasks.edit', $task) }}">@lang('views.task.index.buttons.edit')</a>
                    </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
@endsection