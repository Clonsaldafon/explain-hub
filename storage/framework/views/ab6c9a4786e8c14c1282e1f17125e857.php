<?php $__env->startSection("content"); ?>
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
        <h3 class="h3"><?php echo e($answer->question->title); ?></h3>
        <div class="answer-edit__question-content">
          <p><?php echo e($answer->question->content); ?></p>
        </div>
      </div>
      <form id="answer-form" method="POST" action="<?php echo e('/answers/' . $answer->id); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group">
          <label for="answer-textarea">Содержание</label>
          <textarea
            class="textarea"
            id="answer-textarea"
            name="answer"
            required
          ><?php echo e($answer->answer['text']); ?></textarea>
        </div>
        <button class="button" type="submit">Сохранить</button>
        <?php ($error = session('error')); ?>
        <?php if($error): ?>
            <div class="error"><?php echo e($error); ?></div>
        <?php endif; ?>
      </form>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/answers/answer-edit.blade.php ENDPATH**/ ?>