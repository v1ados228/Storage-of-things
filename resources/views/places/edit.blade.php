@extends('layouts.app')

@section('content')
    <h1 class="page-title">Редактировать место</h1>
    <form method="POST" action="{{ route('places.update', $place) }}" class="mt-3">
        @csrf
        @method('PUT')
        <div>
            <label class="form-label">Название</label>
            <input class="form-control" name="name" value="{{ old('name', $place->name) }}">
        </div>
        <div>
            <label class="form-label">Описание</label>
            <textarea class="form-control" name="description">{{ old('description', $place->description) }}</textarea>
        </div>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="repair" value="1" id="placeRepair"
                    {{ $place->repair ? 'checked' : '' }}>
                <label class="form-check-label" for="placeRepair">Ремонт</label>
            </div>
        </div>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="work" value="1" id="placeWork"
                    {{ $place->work ? 'checked' : '' }}>
                <label class="form-check-label" for="placeWork">В работе</label>
            </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Сохранить</button>
    </form>
@endsection
