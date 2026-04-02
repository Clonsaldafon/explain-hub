@extends('layouts.app')

@section('title', 'Редактировать пользователя')

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <h1>Редактировать пользователя</h1>
  </div>

  <a href="/admin/users" class="back-link">Назад к пользователям</a>

  @if(session('_flash.success'))
    <div class="flash-message flash-success">{{ session('_flash.success') }}</div>
  @endif
  @if(session('_flash.error'))
    <div class="flash-message flash-error">{{ session('_flash.error') }}</div>
  @endif

  <form method="post" action="/admin/users/{{ $user->id }}/update" class="admin-form">
    @csrf
    <div class="form-group">
      <label for="name">Имя</label>
      <input type="text" id="name" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div class="form-group">
      <label for="role">Роль</label>
      <select id="role" name="role" required>
        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
        <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Редактор</option>
        <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Модератор</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
      </select>
    </div>
    <div class="form-group">
      <label for="is_blocked">Заблокирован</label>
      <input type="checkbox" id="is_blocked" name="is_blocked" value="1" {{ $user->is_blocked ? 'checked' : '' }}>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
  </form>
</div>
@endsection