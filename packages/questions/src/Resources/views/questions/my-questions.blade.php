@extends("layouts.app")

@section("content")
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Мои вопросы</h1>
      <div class="section__header-actions">
        <a
          class="button"
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
      <ul class="questions__list">
        @foreach ($questions as $question)
          <li class="questions__item">
            @component('questions::components.question-card', [
              'id' => $question->id,
              'title' => $question->title,
              'content' => $question->content,
              'status' => $question->status,
              'tags' => $question->tags ?? [],
              'views' => $question->views,
              'likes' => $question->likes,
              'author_id' => $question->author_id,
              'liked' => $question->isLikedBy(auth()->id())
            ])
            @endcomponent
          </li>
        @endforeach
      </ul>
    </div>
  </section>
@endsection