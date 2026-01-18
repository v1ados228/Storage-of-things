@extends('layouts.app')

@section('content')
    <h1 class="page-title">Архив</h1>
    @foreach ($archives as $archive)
        <div class="card">
            <div><strong>{{ $archive->name }}</strong></div>
            <div>Описание: {{ $archive->description_text }}</div>
            <div>Хозяин: {{ $archive->owner_name }}</div>
            <div>Последний пользователь: {{ $archive->last_user_name }}</div>
            <div>Место: {{ $archive->place_name }}</div>
            @if ($archive->restored_at)
                <span class="badge">Восстановлено</span>
            @else
                <form method="POST" action="{{ route('archive.restore', $archive) }}">
                    @csrf
                    <button class="btn" type="submit">Восстановить</button>
                </form>
            @endif
        </div>
    @endforeach
@endsection
