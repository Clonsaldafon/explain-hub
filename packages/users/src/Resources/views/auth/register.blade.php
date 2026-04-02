@extends("layouts.app")

@php($old = session('old') ?: [])

@section("content")
  <div class="auth">
    <form
      class="auth__form"
      method="POST"
      action="/register"
    >
      {!! csrf_field() !!}
      <h1 class="auth__title">Регистрация</h1>
      <div class="auth__field">
        <label class="auth__label" for="name-input">Имя</label>
        <input
          class="auth__input"
          id="name-input"
          name="name"
          value="{{ $old['name'] ?? '' }}"
          required
        >
      </div>
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
      <div class="auth__field">
        <label class="auth__label" for="password-confirmation-input">Подтвердите пароль</label>
        <input
          class="auth__input"
          id="password-confirmation-input"
          name="password_confirmation"
          type="password"
          minlength="8"
          required
        >
      </div>
      @php($errors = session('errors'))
      @if($errors && is_array($errors))
          <div class="auth__error">
              @foreach($errors as $field => $messages)
                  @foreach($messages as $message)
                      <p>{{ $message }}</p>
                  @endforeach
              @endforeach
          </div>
      @endif
      <button
        class="auth__button button"
        type="submit"
      >
        Зарегистрироваться
      </button>
      <div class="auth__redirect">
        Уже есть аккаунт?<br/>
        <a
          class="auth__redirect-link"
          href="/login"
        >
          Войти
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