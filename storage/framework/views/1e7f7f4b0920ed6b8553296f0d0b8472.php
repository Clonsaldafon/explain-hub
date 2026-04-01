<?php $__env->startSection("content"); ?>
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Мои ответы</h1>
      <div class="section__header-actions">
        <a
          class="button button--outlined"
          href="/questions"
        >
          Все вопросы
        </a>
        <a
          class="button button--outlined"
          href="/logout"
        >
          Выйти
        </a>
      </div>
    </header>
    <div class="answers__body">
      <ul class="answers__list">
        <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="answers__item">
            <?php $__env->startComponent('questions::components.answer-card', [
              'answer' => $answer,
              'question' => $answer->question
            ]); ?>
            <?php echo $__env->renderComponent(); ?>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/answers/my-answers.blade.php ENDPATH**/ ?>