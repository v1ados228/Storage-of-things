@extends('layouts.app')

@section('content')
    <h1 class="page-title">Создать вещь</h1>
    <form method="POST" action="{{ route('things.store') }}">
        @csrf
        <div>
            <label>Название</label>
            <input name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>Гарантия</label>
            <input name="wrnt" type="date" value="{{ old('wrnt') }}">
        </div>
        <div>
            <label>Количество у владельца</label>
            <input name="total_amount" type="number" min="1" value="{{ old('total_amount', 1) }}">
        </div>
        <div>
            <label>Ед. изм.</label>
            <select name="unit_id">
                <option value="">—</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Описание</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <button class="btn" type="submit">Создать</button>
    </form>
@endsection
