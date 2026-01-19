<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Storage of Things</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-notifications-url="{{ route('notifications.unread') }}">
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('things.index') }}">Storage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('things.index') ? 'active' : '' }}"
                           href="{{ route('things.index') }}">Вещи</a>
                    </li>
                    @if (!auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request('tab') === 'assigned' ? 'active' : '' }}"
                               href="{{ route('things.index', ['tab' => 'assigned']) }}">Мои вещи</a>
                        </li>
                    @endif
                    @can('viewAny', \App\Models\Place::class)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('places.index') ? 'active' : '' }}"
                               href="{{ route('places.index') }}">Места</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('archive.index') ? 'active' : '' }}"
                               href="{{ route('archive.index') }}">Архив</a>
                        </li>
                    @endcan
        @can('access-admin-panel')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.things.index') ? 'active' : '' }}"
                               href="{{ route('admin.things.index') }}">Админ-панель</a>
                        </li>
        @endcan
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Список вещей
                        </button>
                        <ul class="dropdown-menu">
                            @if (auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('things.index', ['tab' => 'my']) }}">Мои вещи</a></li>
                                <li><a class="dropdown-item" href="{{ route('things.index', ['tab' => 'used']) }}">Мои у других</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('things.index', ['tab' => 'assigned']) }}">Мои вещи</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('things.index', ['tab' => 'repair']) }}">В ремонте</a></li>
                            <li><a class="dropdown-item" href="{{ route('things.index', ['tab' => 'work']) }}">В работе</a></li>
                            <li><a class="dropdown-item" href="{{ route('things.index', ['tab' => 'all']) }}">Все вещи</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-info position-relative" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Уведомления
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                id="notificationsCount">{{ auth()->user()->unreadNotifications()->count() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" id="notificationsList"
                            style="max-height: 400px; overflow-y: auto;">
                            @forelse (auth()->user()->unreadNotifications as $notification)
                                <li>
                                    <a class="dropdown-item" href="{{ route('notifications.show', $notification->id) }}">
                                        {{ $notification->data['title'] ?? ($notification->data['thing_name'] ?? 'Уведомление') }}
                        </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text text-muted">Нет уведомлений</span></li>
                            @endforelse
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-outline-danger" type="submit">Выйти</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-4 pb-4">
    @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
