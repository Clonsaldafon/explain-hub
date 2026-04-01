<?php ($old = session('old') ?: []); ?>

<?php $__env->startSection("content"); ?>
  <div class="auth">
    <form
      class="auth__form"
      method="POST"
      action="/login"
    >
      <h1 class="auth__title">Вход</h1>
      <div class="auth__field">
        <label class="auth__label" for="email-input">Email</label>
        <input
          class="auth__input"
          id="email-input"
          name="email"
          type="email"
          value="<?php echo e($old['email'] ?? ''); ?>"
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
      <?php ($error = session('error')); ?>
      <?php if($error): ?>
          <div class="auth__error"><?php echo e($error); ?></div>
      <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/users/src/Providers/../Resources/views/auth/login.blade.php ENDPATH**/ ?>