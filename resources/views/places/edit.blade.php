@extends('layouts.app')

@section('content')
    <h1 class="page-title">Редактировать место</h1>
    <form method="POST" action="{{ route('places.update', $place) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Название</label>
            <input name="name" value="{{ old('name', $place->name) }}">
        </div>
        <div>
            <label>Описание</label>
            <textarea name="description">{{ old('description', $place->description) }}</textarea>
        </div>
        <div>
            <label>Ремонт</label>
            <input type="checkbox" name="repair" value="1" {{ $place->repair ? 'checked' : '' }}>
        </div>
        <div>
            <label>В работе</label>
            <input type="checkbox" name="work" value="1" {{ $place->work ? 'checked' : '' }}>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
@endsection
