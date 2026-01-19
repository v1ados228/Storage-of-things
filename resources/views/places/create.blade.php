@extends('layouts.app')

@section('content')
    <h1 class="page-title">Создать место</h1>
    <form method="POST" action="{{ route('places.store') }}" class="mt-3">
        @csrf
        <div>
            <label class="form-label">Название</label>
            <input class="form-control" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label class="form-label">Описание</label>
            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
        </div>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="repair" value="1" id="placeRepair">
                <label class="form-check-label" for="placeRepair">Ремонт</label>
            </div>
        </div>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="work" value="1" id="placeWork">
                <label class="form-check-label" for="placeWork">В работе</label>
            </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Создать</button>
    </form>
@endsection
