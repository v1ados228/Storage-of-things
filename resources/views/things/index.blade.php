@extends('layouts.app')

@section('content')
    <h1 class="page-title">
        @if ($tab === 'my')
            Мои вещи
        @elseif ($tab === 'assigned')
            Мои вещи (назначенные)
        @elseif ($tab === 'used')
            Мои у других
        @elseif ($tab === 'repair')
            Вещи в ремонте
        @elseif ($tab === 'work')
            Вещи в работе
        @else
            Все вещи
        @endif
    </h1>
    @can('create', \App\Models\Thing::class)
        <a class="btn btn-primary" href="{{ route('things.create') }}">Создать вещь</a>
    @endcan
    <div class="legend mb-3">
        <span class="legend-item place-repair">Оранжевый — ремонт/мойка</span>
        <span class="legend-item place-work">Зелёный — в работе</span>
    </div>

    @forelse ($things as $thing)
        @php
            $usedAmount = $thing->uses->sum('amount');
            $availableAmount = max(0, $thing->total_amount - $usedAmount);
        @endphp
        <div class="card card-clickable" data-href="{{ route('things.show', $thing) }}" @mineClass($thing)>
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                    <strong class="me-2">{{ $thing->name }}</strong>
                    <span class="badge text-bg-secondary">Хозяин: {{ $thing->master?->name }}</span>
                </div>
                <div>Гарантия: {{ $thing->wrnt ?? '—' }}</div>
                <div>Описание: {{ $thing->currentDescription?->description ?? '—' }}</div>
                <div>Количество: {{ $thing->total_amount }} {{ $thing->unit?->abbreviation ?? '' }}</div>
                <div>Доступно: {{ $availableAmount }} {{ $thing->unit?->abbreviation ?? '' }}</div>
                @foreach ($thing->uses as $use)
                    <div class="mt-2" @placeStateClass($use->place)>
                        Пользователь: {{ $use->user?->name }} —
                        {{ $use->amount }} {{ $use->unit?->abbreviation ?? '' }}
                        ({{ $use->place?->name }})
                    </div>
                @endforeach
                <div class="actions">
                    @can('update', $thing)
                        <a class="btn btn-secondary" href="{{ route('things.edit', $thing) }}">Редактировать</a>
                        <a class="btn btn-primary" href="{{ route('things.assign', $thing) }}">Передать</a>
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
        </div>
    @empty
        <div class="card">
            <div class="card-body">
                Пока нет вещей в этом разделе.
            </div>
        </div>
    @endforelse

    <div class="mt-3">
        {{ $things->withQueryString()->links() }}
    </div>
@endsection
