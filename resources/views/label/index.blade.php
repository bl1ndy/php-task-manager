@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('views.label.index.labels')</h1>

    @can('label_actions')
        <a href="{{ route('labels.create') }}" class="btn btn-primary">@lang('views.label.index.buttons.create')</a>
    @endcan

    <table class="table mt-2">
        <thead>
            <tr>
                <th>@lang('models.label.id')</th>
                <th>@lang('models.label.name')</th>
                <th>@lang('models.label.description')</th>
                <th>@lang('models.label.created_at')</th>
                @can('label_actions')
                    <th>@lang('views.label.index.actions')</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at }}</td>
                @can('label_actions')
                    <td>
                        <a class="text-danger" href="{{ route('labels.destroy', $label) }}" data-confirm="Вы уверены?" data-method="delete">@lang('views.label.index.buttons.delete')</a>
                        <a href="{{ route('labels.edit', $label) }}">@lang('views.label.index.buttons.edit')</a>
                    </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $labels->links() }}
@endsection