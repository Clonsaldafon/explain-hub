<article class="answer-card">
  @if ($question)
    <header class="answer-card__header">
      <h3 class="answer-card__title h3">{{ $question->title }}</h3>
      <div class="answer-card__actions">
        @switch($answer->status)
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
        <a
          class="button button--outlined"
          href="{{ '/questions/' . $question->id }}"
        >
          К вопросу
        </a>
      </div>
    </header>
  @endif
  <div class="answer-card__text">
    <p>{{ $answer->answer['text'] }}</p>
  </div>
  <div class="answer-card__footer">
    <div class="answer-card__metrics">
      @component('questions::components.metrics', [
        'value' => $answer->views
      ])
        <svg width="24" height="24" viewBox="0 0 24 24">
          <g
            fill="none" stroke="currentColor"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          >
            <path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/>
            <path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/>
          </g>
        </svg>
      @endcomponent
      <div class="answer-card__metrics-likes">
        @component('questions::components.metrics', [
          'value' => $answer->likes
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
    @if ($question || auth()->id() === $answer->author_id)
      <a
        class="button button--outlined"
        href="{{ '/answers/' . $answer->id . '/edit' }}"
      >
        Редактировать
      </a>
    @endif
  </div>
</article>