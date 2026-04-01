@extends("layouts.app")

@php($old = session('old') ?: [])

@section("content")
  <div class="auth">
    <form
      class="auth__form"
      method="POST"
      action="/login"
    >
      {!! csrf_field() !!}
      <h1 class="auth__title">Вход</h1>
      <div class="auth__field">
        <label class="auth__label" for="email-input">Email</label>
        <input
          class="auth__input"
          id="email-input"
          name="email"
          type="email"
          value="{{ $old['email'] ?? '' }}"
          required
        >
      </div>
      <div class="auth__field">
        <label class="auth__label" for="password-input">Пароль</label>
        <input
          class="auth__input"
          id="password-input"
          name="password"
          type="password"
          minlength="8"
          required
        >
      </div>
      @php($error = session('error'))
      @if($error)
          <div class="auth__error">{{ $error }}</div>
      @endif
      <button
        class="auth__button button"
        type="submit"
      >
        Войти
      </button>
      <div class="auth__redirect">
        Еще нет аккаунта?<br/>
        <a
          class="auth__redirect-link"
          href="/register"
        >
          Зарегистрироваться
        </a>
      </div>
      <div class="auth__redirect">
        <a
          class="auth__redirect-link auth__redirect-link--gray"
          href="/questions"
        >
          Зайти как гость
        </a>
      </div>
    </form>
  </div>
@endsection