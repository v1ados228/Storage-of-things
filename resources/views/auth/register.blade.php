<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Регистрация</title>
    @vite(['resources/css/app.css'])
</head>
<body>
<div class="container">
    <h1 class="page-title">Регистрация</h1>
    @if ($errors->any())
        <div class="card">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <div>
            <label>Имя</label>
            <input name="name" value="{{ old('name') }}">
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            <label>Пароль</label>
            <input type="password" name="password">
        </div>
        <div>
            <label>Подтвердите пароль</label>
            <input type="password" name="password_confirmation">
        </div>
        <button class="btn" type="submit">Зарегистрироваться</button>
    </form>
    <div class="actions">
        <a class="btn btn-outline" href="{{ route('login') }}">Вход</a>
    </div>
</div>
</body>
</html>
