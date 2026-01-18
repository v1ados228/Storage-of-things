@extends('layouts.app')

@section('content')
    <h1 class="page-title">Вещи</h1>
    <a class="btn" href="{{ route('things.create') }}">Создать вещь</a>
    <div class="legend">
        <span class="legend-item place-repair">Оранжевый — ремонт/мойка</span>
        <span class="legend-item place-work">Зелёный — в работе</span>
    </div>

    @foreach ($things as $thing)
        @php
            $usedAmount = $thing->uses->sum('amount');
            $availableAmount = max(0, $thing->total_amount - $usedAmount);
        @endphp
        <div class="card card-clickable" data-href="{{ route('things.show', $thing) }}" @mineClass($thing)>
            <div>
                <strong>{{ $thing->name }}</strong>
                <span class="badge">Хозяин: {{ $thing->master?->name }}</span>
            </div>
            <div>Гарантия: {{ $thing->wrnt ?? '—' }}</div>
            <div>Описание: {{ $thing->currentDescription?->description ?? '—' }}</div>
            <div>Количество: {{ $thing->total_amount }} {{ $thing->unit?->abbreviation ?? '' }}</div>
            <div>Доступно: {{ $availableAmount }} {{ $thing->unit?->abbreviation ?? '' }}</div>
            @foreach ($thing->uses as $use)
                <div @placeStateClass($use->place)>
                    Пользователь: {{ $use->user?->name }} —
                    {{ $use->amount }} {{ $use->unit?->abbreviation ?? '' }}
                    ({{ $use->place?->name }})
                </div>
            @endforeach
            <div class="actions">
                @can('edit-thing', $thing)
                    <a class="btn btn-secondary" href="{{ route('things.edit', $thing) }}">Редактировать</a>
                    <a class="btn" href="{{ route('things.assign', $thing) }}">Передать</a>
                @endcan
                @can('delete', $thing)
                    <form method="POST" action="{{ route('things.destroy', $thing) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Удалить</button>
                    </form>
                @endcan
            </div>
        </div>
    @endforeach
@endsection
