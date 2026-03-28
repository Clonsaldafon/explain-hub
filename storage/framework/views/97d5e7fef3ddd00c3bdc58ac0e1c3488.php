<?php $__env->startSection("content"); ?>
  <div class="auth">
    <form class="auth__form">
      <h1 class="auth__title">Регистрация</h1>
      <div class="auth__field">
        <label class="auth__label" for="fullname-input">ФИО</label>
        <input
          class="auth__input"
          id="fullname-input"
          required
        >
      </div>
      <div class="auth__field">
        <label class="auth__label" for="email-input">Email</label>
        <input
          class="auth__input"
          id="email-input"
          type="email"
          required
        >
      </div>
      <div class="auth__field">
        <label class="auth__label" for="password-input">Пароль</label>
        <input
          class="auth__input"
          id="password-input"
          type="password"
          required
        >
      </div>
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
    </form>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/resources/views/auth/register.blade.php ENDPATH**/ ?>