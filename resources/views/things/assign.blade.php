@extends('layouts.app')

@section('content')
    <h1 class="page-title">Передать: {{ $thing->name }}</h1>
    <div class="card card-body">
        Доступно у владельца: {{ $availableAmount }} {{ $thing->unit?->abbreviation ?? '' }}
    </div>
    <form method="POST" action="{{ route('things.assign.store', $thing) }}" class="mt-3">
        @csrf
        <div>
            <label class="form-label">Пользователь</label>
            <select class="form-select" name="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Место</label>
            <select class="form-select" name="place_id">
                @foreach ($places as $place)
                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Количество</label>
            <input class="form-control" name="amount" type="number" min="1" max="{{ $availableAmount }}" value="{{ old('amount', 1) }}">
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
        <button class="btn btn-primary" type="submit">Назначить</button>
    </form>
@endsection
