@extends('layouts.app')

@section('content')
    <h1 class="page-title">Уведомление</h1>
    <div class="card">
        <div class="card-body">
            <div>{{ $notification->data['title'] ?? 'Уведомление' }}</div>
            <div>{{ $notification->data['message'] ?? ($notification->data['thing_name'] ?? '') }}</div>
            @if (!empty($notification->data['amount']))
                <div>Количество: {{ $notification->data['amount'] }}</div>
            @endif
        </div>
    </div>
    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
        @csrf
        <button class="btn btn-primary" type="submit">Ознакомлен</button>
    </form>
@endsection
