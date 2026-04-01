<?php ($old = session('old') ?: []); ?>

<?php $__env->startSection("content"); ?>
  <div class="auth">
    <form
      class="auth__form"
      method="POST"
      action="/register"
    >
      <?php echo csrf_field(); ?>

      <h1 class="auth__title">Регистрация</h1>
      <div class="auth__field">
        <label class="auth__label" for="name-input">Имя</label>
        <input
          class="auth__input"
          id="name-input"
          name="name"
          value="<?php echo e($old['name'] ?? ''); ?>"
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
      <?php ($errors = session('errors')); ?>
      <?php if($errors && is_array($errors)): ?>
          <div class="auth__error">
              <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $messages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <p><?php echo e($message); ?></p>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
      <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/users/src/Providers/../Resources/views/auth/register.blade.php ENDPATH**/ ?>