@extends('layouts.app')

@section('title', 'Вопросы')

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <h1>Вопросы</h1>
  </div>

  <a href="/admin" class="back-link">Назад в админку</a>

  @if(session('_flash.success'))
    <div class="flash-message flash-success">{{ session('_flash.success') }}</div>
  @endif
  @if(session('_flash.error'))
    <div class="flash-message flash-error">{{ session('_flash.error') }}</div>
  @endif

  <form method="get" action="/admin/questions" class="search-form">
    <input type="text" name="search" placeholder="Поиск по заголовку или содержимому" value="{{ request('search') }}">
    <select name="status">
      <option value="">Все статусы</option>
      <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
      <option value="on_moderate" {{ request('status') == 'on_moderate' ? 'selected' : '' }}>На модерации</option>
      <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Опубликован</option>
      <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Отклонен</option>
    </select>
    <button type="submit" class="btn btn-primary">Поиск</button>
  </form>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Тема</th>
        <th>Автор</th>
        <th>Статус</th>
        <th>Действие</th>
      </tr>
    </thead>
    <tbody>
      @foreach($questions as $question)
      <tr>
        <td>{{ $question->id }}</td>
        <td>{{ $question->title }}</td>
        <td>{{ $question->author->name ?? '-' }}</td>
        <td><span class="status-{{ $question->status }}">{{ $question->status }}</span></td>
        <td>
          <form method="post" action="/admin/questions/{{ $question->id }}/delete" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-danger">Удалить</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $questions->links() }}
</div>
@endsection
