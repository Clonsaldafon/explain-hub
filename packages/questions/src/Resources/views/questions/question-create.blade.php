@extends("layouts.app")

@section("content")
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Создание вопроса</h1>
      <div class="section__header-actions">
         <a
          class="button button--outlined"
          href="/questions"
        >
          Все вопросы
        </a>
        <a
          class="button button--outlined"
          href="/logout"
        >
          Выйти
        </a>
      </div>
    </header>
    <div class="section__body">
      <form id="question-form" method="POST" action="/questions">
        {!! csrf_field() !!}
        <div class="form-group">
          <label for="title">Вопрос</label>
          <input
            class="input"
            id="title"
            name="title"
            type="text"
            required
          >
        </div>
        <div class="form-group">
          <label for="content">Содержание</label>
          <textarea
            class="textarea"
            id="content"
            name="content"
            rows="5"
            required
          ></textarea>
        </div>
        <div class="form-group">
          <label for="tags">Теги (через запятую)</label>
          <input
            class="input"
            id="tags"
            name="tags"
            type="text"
            placeholder="математика, программирование"
          >
        </div>
        <button class="button" type="submit">Опубликовать</button>
        @php($error = session('error'))
        @if($error)
            <div class="error">{{ $error }}</div>
        @endif
      </form>
    </div>
  </section>
@endsection