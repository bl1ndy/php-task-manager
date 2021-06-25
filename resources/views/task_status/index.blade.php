@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('views.task_status.index.statuses')</h1>

    @can('task_status_create')
        <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">@lang('views.task_status.index.buttons.create')</a>
    @endcan

    <table class="table mt-2">
        <thead>
            <tr>
                <th>@lang('models.task_status.id')</th>
                <th>@lang('models.task_status.name')</th>
                <th>@lang('models.task_status.created_at')</th>
                @can('task_status_destroy')
                    <th>@lang('views.task_status.index.actions')</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($taskStatuses as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->name }}</td>
                <td>{{ $status->created_at->format('d.m.Y') }}</td>
                @can('task_status_destroy')
                    <td>
                        <a class="text-danger" href="{{ route('task_statuses.destroy', $status) }}" data-confirm="Вы уверены?" data-method="delete">@lang('views.task_status.index.buttons.delete')</a>
                        <a href="{{ route('task_statuses.edit', $status) }}">@lang('views.task_status.index.buttons.edit')</a>
                    </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $taskStatuses->links() }}
@endsection