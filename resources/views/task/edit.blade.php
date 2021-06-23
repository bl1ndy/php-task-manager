@extends('layouts.app')

@section('content')

<h1 class="mb-5">@lang('views.task.edit.edit_task')</h1>
{{ Form::model($task, ['url' => route('tasks.update', $task), 'method' => 'PATCH', 'class' => 'w-50']) }}
    <div class="form-group">
        {{ Form::label('name', __('models.task.name')) }}
        {{ Form::text('name', $task->name, ['class' => $errors->get('name') ? 'form-control is-invalid' : 'form-control']) }}
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        {{ Form::label('description', __('models.task.description')) }}
        {{ Form::textarea('description', $task->description, ['class' => 'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('status_id', __('models.task.status')) }}
        {{ Form::select('status_id', $taskStatuses, $task->status_id, ['class' => $errors->get('status_id') ? 'form-control is-invalid' : 'form-control']) }}
        @error('status_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        {{ Form::label('assigned_to_id', __('models.task.executor')) }}
        {{ Form::select('assigned_to_id', $executors, $task->assigned_by_id, ['class' => 'form-control', 'placeholder' => '----------']) }}
    </div>
    <div class="form-group">
        {{ Form::label('labels', __('views.label.index.labels')) }}
        {{ Form::select('labels[]', $labels, $selectedLabels, ['multiple', 'class' => 'form-control', 'placeholder' => '']) }}
    </div>
    {{ Form::submit(__('views.task.edit.buttons.update'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

@endsection