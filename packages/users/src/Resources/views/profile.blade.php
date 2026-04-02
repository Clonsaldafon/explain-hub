@extends("layouts.app")

@section("content")
  <section class="section container">
    <header class="section__header">
      <nav class="section__nav">
        <ul class="section__nav-list">
          <li class="section__nav-item">
            <a class="section__nav-link" href="/questions">Все вопросы</a>
          </li>
          <li class="section__nav-item">
            <a class="section__nav-link" href="/my-questions">Мои вопросы</a>
          </li>
          <li class="section__nav-item">
            <a class="section__nav-link" href="/my-answers">Мои ответы</a>
          </li>
        </ul>
      </nav>
      <div class="section__header-actions">
        @if(session('user_role') === 'admin')
          <a
            class="button"
            href="/admin"
          >
            <span>Админ-панель</span>
            <svg
              width="24" height="24" viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M17 17q.625 0 1.063-.437T18.5 15.5t-.437-1.062T17 14t-1.062.438T15.5 15.5t.438 1.063T17 17m0 3q.775 0 1.425-.363t1.05-.962q-.55-.325-1.175-.5T17 18t-1.3.175t-1.175.5q.4.6 1.05.963T17 20m-5 2q-3.475-.875-5.738-3.988T4 11.1V6.375q0-.625.363-1.125t.937-.725l6-2.25q.35-.125.7-.125t.7.125l6 2.25q.575.225.938.725T20 6.375v4.3q-.475-.2-.975-.363T18 10.076V6.4l-6-2.25L6 6.4v4.7q0 1.175.313 2.35t.875 2.238T8.55 17.65t1.775 1.5q.275.8.725 1.525t1.025 1.3q-.025 0-.037.013T12 22m5 0q-2.075 0-3.537-1.463T12 17t1.463-3.537T17 12t3.538 1.463T22 17t-1.463 3.538T17 22m-5-10.35"
              />
            </svg>
          </a>
        @endif
        <a class="button button--outlined" href="/logout">Выйти</a>
      </div>
    </header>
    <div class="section__body">
      <h1 class="section__title h1">Профиль пользователя</h1>
      <p>Вы вошли как: {{ session('user_name') ?? '-' }} ({{ session('user_role') ?? '-' }})</p>
      <div class="profile__stats">
        <h2 class="h2">Статистика</h2>
        <ul class="profile__stats-list">
          <li class="profile__stats-item">
            <h2 class="h3">Количество вопросов</h2>
            <span>{{ $stats['questions_count'] }}</span>
          </li>
          <li class="profile__stats-item">
            <h2 class="h3">Количество ответов</h2>
            <span>{{ $stats['answers_count'] }}</span>
          </li>
          <li class="profile__stats-item">
            <h2 class="h3">Рейтинг</h2>
            <span>{{ $stats['rating'] }}</span>
          </li>
          <li class="profile__stats-item">
            <h2 class="h3">Аккаунт создан</h2>
            <span>{{ $stats['account_created'] }}</span>
          </li>
        </ul>
      </div>
      <div class="questions">
        <h2 class="h2">Недавние вопросы</h2>
        <ul class="questions__list">
          @foreach ($recentQuestions as $question)
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
      <div class="answers">
        <header class="answers__header">
          <h2 class="answers__title h2">Недавние ответы</h2>
        </header>
        <div class="answers__body">
          <ul class="answers__list">
            @foreach ($recentAnswers as $answer)
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