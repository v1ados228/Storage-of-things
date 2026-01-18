@extends('layouts.app')

@section('content')
    <h1 class="page-title">Места хранения</h1>
    @can('create', \App\Models\Place::class)
        <a class="btn" href="{{ route('places.create') }}">Создать место</a>
    @endcan

    @foreach ($places as $place)
        <div class="card" @placeStateClass($place)>
            <strong>{{ $place->name }}</strong>
            <div>{{ $place->description }}</div>
            <div>Ремонт: {{ $place->repair ? 'да' : 'нет' }}</div>
            <div>В работе: {{ $place->work ? 'да' : 'нет' }}</div>
            <div class="actions">
                @can('update', $place)
                    <a class="btn btn-secondary" href="{{ route('places.edit', $place) }}">Редактировать</a>
                @endcan
                @can('delete', $place)
                    <form method="POST" action="{{ route('places.destroy', $place) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Удалить</button>
                    </form>
                @endcan
            </div>
        </div>
    @endforeach
@endsection
