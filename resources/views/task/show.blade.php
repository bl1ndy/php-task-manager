@extends('layouts.app')

@section('content')

    <h1 class="mb-5">@lang('views.task.show.show_task'): {{ $task->name }} <a href="{{ route('tasks.edit', $task) }}">⚙</a></h1>
    <p>@lang('models.task.name'): {{ $task->name }}</p>
    <p>@lang('models.task.status'): {{ $task->status->name }}</p>
    <p>@lang('models.task.description'): {{ $task->description}}</p>
    @if ($task->labels->isNotEmpty())
        <p>@lang('views.task.show.tags'): </p>
        <ul>
            @foreach ($task->labels as $label)
                <li>{{ $label->name }}</li>
            @endforeach
        </ul>
    @endif

@endsection