@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('views.task_status.index.statuses')</h1>

    @auth
        <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">@lang('views.task_status.index.buttons.create')</a>
    @endauth

    <table class="table mt-2">
        <thead>
            <tr>
                <th>@lang('models.task_status.id')</th>
                <th>@lang('models.task_status.name')</th>
                <th>@lang('models.task_status.created_at')</th>
                @auth
                    <th>@lang('views.task_status.index.actions')</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($taskStatuses as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->name }}</td>
                <td>{{ $status->created_at->format('d.m.Y') }}</td>
                @auth
                    <td>
                        @can('delete', $status)
                            <a class="text-danger" href="{{ route('task_statuses.destroy', $status) }}" data-confirm="Вы уверены?" data-method="delete">@lang('views.task_status.index.buttons.delete')</a>
                        @endcan
                        @can('update', $status)
                            <a href="{{ route('task_statuses.edit', $status) }}">@lang('views.task_status.index.buttons.edit')</a>
                        @endcan
                    </td>
                @endauth
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $taskStatuses->links() }}
@endsection