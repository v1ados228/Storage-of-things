@extends('layouts.app')

@section('content')
    <h1 class="page-title">Уведомления</h1>
    @foreach ($notifications as $notification)
        @php
            $title = $notification->data['title'] ?? 'Уведомление';
            $message = $notification->data['message'] ?? ($notification->data['thing_name'] ?? '');
        @endphp
        <div class="card">
            <div>{{ $title }}</div>
            <div>{{ $message }}</div>
            <div class="actions">
                <a class="btn btn-outline" href="{{ route('notifications.show', $notification->id) }}">Открыть</a>
            </div>
        </div>
    @endforeach
@endsection
