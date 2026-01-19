<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="container mt-4">
    <h1 class="page-title">Регистрация</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('register.submit') }}" class="mt-3">
        @csrf
        <div>
            <label class="form-label">Имя</label>
            <input class="form-control" name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            <label class="form-label">Пароль</label>
            <input class="form-control" type="password" name="password">
        </div>
        <div>
            <label class="form-label">Подтвердите пароль</label>
            <input class="form-control" type="password" name="password_confirmation">
        </div>
        <button class="btn btn-primary" type="submit">Зарегистрироваться</button>
    </form>
    <div class="mt-3">
        <a class="btn btn-outline-secondary" href="{{ route('login') }}">Вход</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
