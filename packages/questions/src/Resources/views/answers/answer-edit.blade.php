@extends("layouts.app")

@section("content")
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Редактирование ответа</h1>
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
      <div class="answer-edit__question">
        <h2 class="h2">Вопрос</h2>
        <h3 class="h3">{{ $answer->question->title }}</h3>
        <div class="answer-edit__question-content">
          <p>{{ $answer->question->content }}</p>
        </div>
      </div>
      <form
        id="answer-form"
        method="POST"
        action="{{ '/answers/' . $answer->id }}"
      >
        <input type="hidden" name="_method" value="PUT">
        {!! csrf_field() !!}
        <div class="form-group">
          <label for="answer-textarea">Содержание</label>
          <textarea
            class="textarea"
            id="answer-textarea"
            name="answer"
            required
          >{{ $answer->answer['text'] }}</textarea>
        </div>
        <button class="button" type="submit">Сохранить</button>
        @php($error = session('error'))
        @if($error)
            <div class="error">{{ $error }}</div>
        @endif
      </form>
    </div>
  </section>
@endsection