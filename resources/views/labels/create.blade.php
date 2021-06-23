@extends('layouts.app')

@section('content')

<h1 class="mb-5">@lang('views.label.create.create_label')</h1>
{{ Form::model($label, ['url' => route('labels.store'), 'class' => 'w-50']) }}
    <div class="form-group">
        {{ Form::label('name', __('models.label.name')) }}
        {{ Form::text('name', null, ['class' => $errors->any() ? 'form-control is-invalid' : 'form-control']) }}
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    {{ Form::submit(__('views.label.create.buttons.create'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

@endsection