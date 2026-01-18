@extends('layouts.app')

@section('content')
    <h1 class="page-title">Админ: все вещи</h1>
    @foreach ($things as $thing)
        <div class="card">
            <div><strong>{{ $thing->name }}</strong></div>
            <div>Хозяин: {{ $thing->master?->name }}</div>
            <div>Гарантия: {{ $thing->wrnt ?? '—' }}</div>
            <div>Описание: {{ $thing->currentDescription?->description ?? '—' }}</div>
            @foreach ($thing->uses as $use)
                <div>
                    Пользователь: {{ $use->user?->name }} —
                    {{ $use->amount }} {{ $use->unit?->abbreviation ?? '' }}
                    ({{ $use->place?->name }})
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
