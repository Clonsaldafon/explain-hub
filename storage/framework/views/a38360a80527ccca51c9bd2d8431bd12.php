<?php $__env->startSection("content"); ?>
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Вопрос</h1>
      <div class="section__header-actions">
        <a
          class="button button--outlined"
          href="javascript:history.back()"
        >
          Назад
        </a>
        <?php if(auth()->check()): ?>
          <a
            class="button button--outlined"
            href="/logout"
          >
            Выйти
          </a>
        <?php else: ?>
          <a
            class="button"
            href="/login"
          >
            Вход
          </a>
        <?php endif; ?>
      </div>
    </header>
    <div class="section__body">
      "title": <?php echo e($question->title); ?>

    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/questions/question.blade.php ENDPATH**/ ?>