<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Storage of Things</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav>
        <a href="{{ route('things.index') }}">Вещи</a>
        @can('viewAny', \App\Models\Place::class)
            <a href="{{ route('places.index') }}">Места</a>
        @endcan
        <a href="{{ route('archive.index') }}">Архив</a>
        @can('access-admin-panel')
            <a href="{{ route('admin.things.index') }}">Админ-панель</a>
        @endcan

        <details class="dropdown">
            <summary>Список вещей</summary>
            <div class="dropdown-menu">
                <a href="{{ route('things.index', ['tab' => 'my']) }}" @tabActive('my')>Мои вещи</a>
                <a href="{{ route('things.index', ['tab' => 'repair']) }}" @tabActive('repair')>В ремонте</a>
                <a href="{{ route('things.index', ['tab' => 'work']) }}" @tabActive('work')>В работе</a>
                <a href="{{ route('things.index', ['tab' => 'used']) }}" @tabActive('used')>Мои у других</a>
                <a href="{{ route('things.index', ['tab' => 'all']) }}" @tabActive('all')>Все вещи</a>
            </div>
        </details>

        <details class="dropdown">
            <summary class="badge">
                Уведомления: {{ auth()->user()->unreadNotifications()->count() }}
            </summary>
            <div class="dropdown-menu">
                @foreach (auth()->user()->unreadNotifications as $notification)
                    <div>
                        <a href="{{ route('notifications.show', $notification->id) }}">
                            {{ $notification->data['title'] ?? ($notification->data['thing_name'] ?? 'Уведомление') }}
                        </a>
                    </div>
                @endforeach
            </div>
        </details>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button class="btn btn-outline" type="submit">Выйти</button>
        </form>
    </nav>
</header>

<div class="container">
    @if (session('status'))
        <div class="alert">
            {{ session('status') }}
        </div>
    @endif
    @yield('content')
</div>
</body>
</html>
