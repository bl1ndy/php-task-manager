@extends('layouts.app')

@section('content')

    <h1 class="mb-5">@lang('views.task.show.show_task'): {{ $task->name }} <a href="{{ route('tasks.edit', $task) }}">⚙</a></h1>
    <p>@lang('models.task.name'): {{ $task->name }}</p>
    <p>@lang('models.task.status'): {{ $statusName }}</p>
    <p>@lang('models.task.description'): {{ $task->description}}</p>
    <p>@lang('views.task.show.tags'): </p>

@endsection