@extends('layouts.app')

@section('content')
    <h1 class="page-title">{{ $thing->name }}</h1>
    @php
        $usedAmount = $thing->uses->sum('amount');
        $availableAmount = max(0, $thing->total_amount - $usedAmount);
    @endphp
    <div class="card">
        <div>Хозяин: {{ $thing->master?->name }}</div>
        <div>Гарантия: {{ $thing->wrnt ?? '—' }}</div>
        <div>Актуальное описание: {{ $thing->currentDescription?->description ?? '—' }}</div>
        <div>Количество: {{ $thing->total_amount }} {{ $thing->unit?->abbreviation ?? '' }}</div>
        <div>Доступно: {{ $availableAmount }} {{ $thing->unit?->abbreviation ?? '' }}</div>
    </div>

    <h2>Передачи</h2>
    @foreach ($thing->uses as $use)
        <div class="card" @placeStateClass($use->place)>
            <div>Пользователь: {{ $use->user?->name }}</div>
            <div>Место: {{ $use->place?->name }}</div>
            <div>Количество: {{ $use->amount }} {{ $use->unit?->abbreviation ?? '' }}</div>
        </div>
    @endforeach

    @can('update', $thing)
        <div class="actions">
            <a class="btn" href="{{ route('things.assign', $thing) }}">Передать</a>
        </div>
    @endcan

    <h2>История описаний</h2>
    @foreach ($thing->descriptions as $description)
        <div class="card">
            <div>{{ $description->description }}</div>
            <div>Автор: {{ $description->author?->name }}</div>
            @if ($thing->current_description_id === $description->id)
                <span class="badge">Текущее</span>
            @else
                @can('update', $thing)
                    <form method="POST" action="{{ route('things.descriptions.current', [$thing, $description]) }}" class="inline">
                        @csrf
                        <button class="btn btn-outline" type="submit">Сделать текущим</button>
                    </form>
                @endcan
            @endif
        </div>
    @endforeach

    @can('update', $thing)
        <h3>Добавить описание</h3>
        <form method="POST" action="{{ route('things.descriptions.store', $thing) }}">
            @csrf
            <textarea name="description">{{ old('description') }}</textarea>
            <button class="btn" type="submit">Добавить</button>
        </form>
    @endcan
@endsection
