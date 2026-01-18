<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Вход</title>
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="container">
    <h1 class="page-title">Вход</h1>
    @if ($errors->any())
        <div class="card">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            <label>Пароль</label>
            <input type="password" name="password">
        </div>
        <button class="btn" type="submit">Войти</button>
    </form>
    <div class="actions">
        <a class="btn btn-outline" href="{{ route('register') }}">Регистрация</a>
    </div>
</div>
</body>
</html>
