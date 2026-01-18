@extends('layouts.app')

@section('content')
    <h1 class="page-title">Редактировать вещь</h1>
    <form method="POST" action="{{ route('things.update', $thing) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Название</label>
            <input name="name" value="{{ old('name', $thing->name) }}">
        </div>
        <div>
            <label>Гарантия</label>
            <input name="wrnt" type="date" value="{{ old('wrnt', $thing->wrnt) }}">
        </div>
        <div>
            <label>Количество у владельца</label>
            <input name="total_amount" type="number" min="1" value="{{ old('total_amount', $thing->total_amount) }}">
        </div>
        <div>
            <label>Ед. изм.</label>
            <select name="unit_id">
                <option value="">—</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ (int) old('unit_id', $thing->unit_id) === $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button class="btn" type="submit">Сохранить</button>
    </form>
@endsection
