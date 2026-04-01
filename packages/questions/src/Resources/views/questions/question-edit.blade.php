@extends("layouts.app")

@section("content")
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Редактирование вопроса</h1>
      <div class="section__header-actions">
         <a
          class="button button--outlined"
          href="javascript:history.back()"
        >
          Назад
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
      "title": {{ $question->title }}
    </div>
  </section>
@endsection