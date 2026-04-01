<?php $__env->startSection("content"); ?>
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Мои вопросы</h1>
      <div class="section__header-actions">
        <a
          class="button"
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
    <div class="section__body">
      <ul class="questions__list">
        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="questions__item">
            <?php $__env->startComponent('questions::components.question-card', [
              'id' => $question->id,
              'title' => $question->title,
              'content' => $question->content,
              'status' => $question->status,
              'tags' => $question->tags ?? [],
              'views' => $question->views,
              'likes' => $question->likes,
              'author_id' => $question->author_id
            ]); ?>
            <?php echo $__env->renderComponent(); ?>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/questions/my-questions.blade.php ENDPATH**/ ?>