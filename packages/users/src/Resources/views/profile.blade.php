@extends("layouts.app")

@section("content")
  <h1>Профиль пользователя</h1>
  <p>Вы вошли как: {{ session('user_name') ?? '-' }} ({{ session('user_role') ?? '-' }})</p>
  <p><a href="/logout">Выйти</a></p>

  @if(session('user_role') === 'admin')
    <p><a href="/admin">Перейти в админку</a></p>
  @endif
@endsection