@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('views.label.index.labels')</h1>

    @auth
        <a href="{{ route('labels.create') }}" class="btn btn-primary">@lang('views.label.index.buttons.create')</a>
    @endauth

    <table class="table mt-2">
        <thead>
            <tr>
                <th>@lang('models.label.id')</th>
                <th>@lang('models.label.name')</th>
                <th>@lang('models.label.description')</th>
                <th>@lang('models.label.created_at')</th>
                @auth
                    <th>@lang('views.label.index.actions')</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at->format('d.m.Y') }}</td>
                @auth
                    <td>
                        @can('delete', $label)
                            <a class="text-danger" href="{{ route('labels.destroy', $label) }}" data-confirm="Вы уверены?" data-method="delete">@lang('views.label.index.buttons.delete')</a>
                        @endcan
                        @can('update', $label)
                            <a href="{{ route('labels.edit', $label) }}">@lang('views.label.index.buttons.edit')</a>
                        @endcan
                    </td>
                @endauth
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $labels->links() }}
@endsection