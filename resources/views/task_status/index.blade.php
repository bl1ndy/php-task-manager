@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Статусы</h1>

    @can('create')
        <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Создать статус</a>
    @endcan

    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Дата создания</th>
                @can('destroy')
                    <th>Действия</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($taskStatuses as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->name }}</td>
                <td>{{ $status->created_at }}</td>
                @can('destroy')
                    <td>
                        <a class="text-danger" href="" data-confirm="Вы уверены?" data-method="delete">Удалить</a>
                        <a href="{{ route('task_statuses.edit', $status) }}">Изменить</a>
                    </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $taskStatuses->links() }}
@endsection