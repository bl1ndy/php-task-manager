@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">Статусы</h1>

    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Создать статус</a>

    <table class="table mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taskStatuses as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->name }}</td>
                <td>{{ $status->created_at }}</td>
                <td>
                    <a class="text-danger" href="" data-confirm="Вы уверены?" data-method="delete">Удалить</a>
                    <a href="">Изменить</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $taskStatuses->links() }}
</div>
@endsection