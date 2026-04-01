@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <h1>Пользователи</h1>
  </div>

  <a href="/admin" class="back-link">Назад в админку</a>

  @if(session('_flash.success'))
    <div class="flash-message flash-success">{{ session('_flash.success') }}</div>
  @endif
  @if(session('_flash.error'))
    <div class="flash-message flash-error">{{ session('_flash.error') }}</div>
  @endif

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Заблокирован</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
        <td>{{ $user->is_blocked ? 'Да' : 'Нет' }}</td>
        <td>
          @if(!$user->is_blocked && !$user->isAdmin())
            <form method="post" action="/admin/users/{{ $user->id }}/ban" style="display:inline">
              @csrf
              <button type="submit" class="btn btn-danger">Блокировать</button>
            </form>
          @elseif($user->is_blocked)
            <form method="post" action="/admin/users/{{ $user->id }}/unban" style="display:inline">
              @csrf
              <button type="submit" class="btn btn-success">Разблокировать</button>
            </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
