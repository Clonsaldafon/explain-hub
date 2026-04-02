@extends('layouts.app')

@section('title', 'Ответы')

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <h1>Ответы</h1>
  </div>

  <a href="/admin" class="back-link">Назад в админку</a>

  @if(session('_flash.success'))
    <div class="flash-message flash-success">{{ session('_flash.success') }}</div>
  @endif
  @if(session('_flash.error'))
    <div class="flash-message flash-error">{{ session('_flash.error') }}</div>
  @endif

  <form method="get" action="/admin/answers" class="search-form">
    <input type="text" name="search" placeholder="Поиск по содержимому ответа" value="{{ request('search') }}">
    <select name="status">
      <option value="">Все статусы</option>
      <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
      <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Опубликован</option>
      <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Отклонен</option>
    </select>
    <button type="submit" class="btn btn-primary">Поиск</button>
  </form>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Вопрос</th>
        <th>Автор</th>
        <th>Статус</th>
        <th>Действие</th>
      </tr>
    </thead>
    <tbody>
      @foreach($answers as $answer)
      <tr>
        <td>{{ $answer->id }}</td>
        <td>{{ $answer->question->title ?? '-' }}</td>
        <td>{{ $answer->author->name ?? '-' }}</td>
        <td><span class="status-{{ $answer->status }}">{{ $answer->status }}</span></td>
        <td>
          <form method="post" action="/admin/answers/{{ $answer->id }}/delete" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-danger">Удалить</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $answers->links() }}
</div>
@endsection
