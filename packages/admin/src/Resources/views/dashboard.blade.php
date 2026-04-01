@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <h1>Админ-панель</h1>
  </div>

  <div class="admin-stats">
    <div class="stat-card">
      <h3>Всего пользователей</h3>
      <p class="number">{{ $totalUsers }}</p>
    </div>
    <div class="stat-card">
      <h3>Заблокировано</h3>
      <p class="number">{{ $blockedUsers }}</p>
    </div>
    <div class="stat-card">
      <h3>Всего вопросов</h3>
      <p class="number">{{ $totalQuestions }}</p>
    </div>
    <div class="stat-card">
      <h3>Всего ответов</h3>
      <p class="number">{{ $totalAnswers }}</p>
    </div>
  </div>

  <div class="admin-nav">
    <a href="/admin/users">Управление пользователями</a>
    <a href="/admin/questions">Управление вопросами</a>
    <a href="/admin/answers">Управление ответами</a>
  </div>
</div>
@endsection
