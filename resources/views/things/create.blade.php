@extends('layouts.app')

@section('content')
    <h1 class="page-title">Создать вещь</h1>
    <form method="POST" action="{{ route('things.store') }}" class="mt-3">
        @csrf
        <div>
            <label class="form-label">Название</label>
            <input class="form-control" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label class="form-label">Гарантия</label>
            <input class="form-control" name="wrnt" type="date" value="{{ old('wrnt') }}">
        </div>
        <div>
            <label class="form-label">Количество у владельца</label>
            <input class="form-control" name="total_amount" type="number" min="1" value="{{ old('total_amount', 1) }}">
        </div>
        <div>
            <label class="form-label">Ед. изм.</label>
            <select class="form-select" name="unit_id">
                <option value="">—</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Описание</label>
            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Создать</button>
    </form>
@endsection
