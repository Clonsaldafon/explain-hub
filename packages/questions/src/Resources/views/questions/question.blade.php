@extends("layouts.app")

@section("content")
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Вопрос</h1>
      <div class="section__header-actions">
        <a
          class="button button--outlined"
          href="/questions"
        >
          Все вопросы
        </a>
        @if (auth()->check())
          <a
            class="button button--outlined"
            href="/logout"
          >
            Выйти
          </a>
        @else
          <a
            class="button"
            href="/login"
          >
            Вход
          </a>
        @endif
      </div>
    </header>
    <div class="section__body">
      <div class="question">
        <header class="question__header">
          <h2 class="question__title h2">{{ $question->title }}</h2>
          @switch($question->status)
            @case("published")
              <div class="status status--published">
                опубликован
              </div>
              @break
            @case("on_moderate")
              <div class="status status--on-moderate">
                на модерации
              </div>
              @break
            @case("rejected")
              <div class="status status--rejected">
                отклонен
              </div>
              @break
            @default
              <div class="status">
                черновик
              </div>
              @break
          @endswitch
        </header>
        <div class="question__content">
          <p>{{ $question->content }}</p>
        </div>
        <footer class="question__footer">
          <div class="question__metrics">
            @component('questions::components.metrics', [
              'value' => $question->views
            ])
              <svg
                class="question-card__header-more-icon"
                width="24" height="24" viewBox="0 0 24 24"
              >
                <g
                  fill="none" stroke="currentColor"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                >
                  <path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/>
                  <path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/>
                </g>
              </svg>
            @endcomponent
            <div class="question__metrics-likes">
              @component('questions::components.metrics', [
                'value' => $question->likes
              ])
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <path
                    fill="currentColor"
                    d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2M4 10h2v9H4zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7z"
                  />
                </svg>
              @endcomponent
            </div>
          </div>
          @if (auth()->id() === $question->author_id)
            <a
              class="button button--outlined"
              href="{{ '/questions/' . $question->id . '/edit' }}"
            >
              Редактировать
            </a>
          @endif
        </footer>
      </div>
      <div class="answers">
        <header class="answers__header">
          <h2 class="answers__title h2">Ответы</h2>
        </header>
        <div class="answers__body">
          @if (auth()->check())
            <form
              class="answers__form"
              method="POST"
              action="{{ '/questions/' . $question->id . '/answers' }}"
            >
              {!! csrf_field() !!}
              <textarea
                class="answers__form-textarea textarea"
                name="answer"
                id="answer-textarea"
                required
              ></textarea>
              <button class="button" type="submit">Добавить ответ</button>
            </form>
          @else
            <button class="button button--disabled">Войдите, чтобы ответить</button>
          @endif
          {{ session('error') }}
          <ul class="answers__list">
            @foreach ($answers as $answer)
              <li class="answers__item">
                @component('questions::components.answer-card', [
                  'answer' => $answer,
                  'question' => null
                ])
                @endcomponent
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </section>
@endsection