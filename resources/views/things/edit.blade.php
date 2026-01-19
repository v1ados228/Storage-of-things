@extends('layouts.app')

@section('content')
    <h1 class="page-title">Редактировать вещь</h1>
    <form method="POST" action="{{ route('things.update', $thing) }}" class="mt-3">
        @csrf
        @method('PUT')
        <div>
            <label class="form-label">Название</label>
            <input class="form-control" name="name" value="{{ old('name', $thing->name) }}">
        </div>
        <div>
            <label class="form-label">Гарантия</label>
            <input class="form-control" name="wrnt" type="date" value="{{ old('wrnt', $thing->wrnt) }}">
        </div>
        <div>
            <label class="form-label">Количество у владельца</label>
            <input class="form-control" name="total_amount" type="number" min="1" value="{{ old('total_amount', $thing->total_amount) }}">
        </div>
        <div>
            <label class="form-label">Ед. изм.</label>
            <select class="form-select" name="unit_id">
                <option value="">—</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ (int) old('unit_id', $thing->unit_id) === $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Сохранить</button>
    </form>
@endsection
