@extends('layouts.app')

@section('content')
    <h1 class="page-title">Создать место</h1>
    <form method="POST" action="{{ route('places.store') }}">
        @csrf
        <div>
            <label>Название</label>
            <input name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>Описание</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <div>
            <label>Ремонт</label>
            <input type="checkbox" name="repair" value="1">
        </div>
        <div>
            <label>В работе</label>
            <input type="checkbox" name="work" value="1">
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
@endsection
