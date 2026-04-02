@extends("layouts.app")

@section("content")
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Мои ответы</h1>
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
    <div class="answers__body">
      <ul class="answers__list">
        @foreach ($answers as $answer)
          <li class="answers__item">
            @component('questions::components.answer-card', [
              'answer' => $answer,
              'question' => $answer->question
            ])
            @endcomponent
          </li>
        @endforeach
      </ul>
    </div>
  </section>
@endsection