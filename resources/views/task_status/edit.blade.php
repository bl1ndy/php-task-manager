@extends('layouts.app')

@section('content')

<h1 class="mb-5">@lang('views.task_status.edit.edit_status')</h1>
{{ Form::model($taskStatus, ['url' => route('task_statuses.update', $taskStatus), 'method' => 'PATCH', 'class' => 'w-50']) }}
    <div class="form-group">
        {{ Form::label('name', __('models.task_status.name')) }}
        {{ Form::text('name', $taskStatus->name, ['class' => $errors->any() ? 'form-control is-invalid' : 'form-control']) }}
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    {{ Form::submit(__('views.task_status.edit.buttons.update'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

@endsection