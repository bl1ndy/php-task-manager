@extends('layouts.app')

@section('content')

<h1 class="mb-5">Изменение статуса</h1>
{{ Form::model($taskStatus, ['url' => route('task_statuses.update', $taskStatus), 'method' => 'PATCH', 'class' => 'w-50']) }}
    <div class="form-group">
        {{ Form::label('name', 'Имя') }}
        {{ Form::text('name', $taskStatus->name, ['class' => $errors->any() ? 'form-control is-invalid' : 'form-control']) }}
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    {{ Form::submit('Обновить', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

@endsection