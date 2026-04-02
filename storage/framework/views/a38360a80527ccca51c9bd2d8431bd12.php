<?php $__env->startSection("content"); ?>
  <section class="section container">
    <header class="section__header">
      <h1 class="section__title h1">Вопрос</h1>
      <div class="section__header-actions">
        <a
          class="button button--outlined"
          href="/questions"
        >
          Все вопросы
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
      <div class="question">
        <header class="question__header">
          <h2 class="question__title h2"><?php echo e($question->title); ?></h2>
          <?php switch($question->status):
            case ("published"): ?>
              <div class="status status--published">
                опубликован
              </div>
              <?php break; ?>
            <?php case ("on_moderate"): ?>
              <div class="status status--on-moderate">
                на модерации
              </div>
              <?php break; ?>
            <?php case ("rejected"): ?>
              <div class="status status--rejected">
                отклонен
              </div>
              <?php break; ?>
            <?php default: ?>
              <div class="status">
                черновик
              </div>
              <?php break; ?>
          <?php endswitch; ?>
        </header>
        <div class="question__content">
          <p><?php echo e($question->content); ?></p>
        </div>
        <footer class="question__footer">
          <div class="question__metrics">
            <?php $__env->startComponent('questions::components.metrics', [
              'value' => $question->views
            ]); ?>
              <svg
                class="question-card__header-more-icon"
                width="24" height="24" viewBox="0 0 24 24"
              >
                <g
                  fill="none" stroke="currentColor"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                >
                  <path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/>
                  <path d="M2 12c1.6-4.097 5.336-7 10-7s8.4 2.903 10 7c-1.6 4.097-5.336 7-10 7s-8.4-2.903-10-7"/>
                </g>
              </svg>
            <?php echo $__env->renderComponent(); ?>
            <div class="question__metrics-likes">
              <?php $__env->startComponent('questions::components.metrics', [
                'value' => $question->likes
              ]); ?>
                <svg width="24" height="24" viewBox="0 0 24 24">
                  <path
                    fill="currentColor"
                    d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2M4 10h2v9H4zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7z"
                  />
                </svg>
              <?php echo $__env->renderComponent(); ?>
            </div>
          </div>
          <?php if(auth()->id() === $question->author_id): ?>
            <a
              class="button button--outlined"
              href="<?php echo e('/questions/' . $question->id . '/edit'); ?>"
            >
              Редактировать
            </a>
          <?php endif; ?>
        </footer>
      </div>
      <div class="answers">
        <header class="answers__header">
          <h2 class="answers__title h2">Ответы</h2>
        </header>
        <div class="answers__body">
          <?php if(auth()->check()): ?>
            <form
              class="answers__form"
              method="POST"
              action="<?php echo e('/questions/' . $question->id . '/answers'); ?>"
            >
              <?php echo csrf_field(); ?>

              <textarea
                class="answers__form-textarea textarea"
                name="answer"
                id="answer-textarea"
                required
              ></textarea>
              <button class="button" type="submit">Добавить ответ</button>
            </form>
          <?php else: ?>
            <button class="button button--disabled">Войдите, чтобы ответить</button>
          <?php endif; ?>
          <?php echo e(session('error')); ?>

          <ul class="answers__list">
            <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="answers__item">
                <?php $__env->startComponent('questions::components.answer-card', [
                  'answer' => $answer,
                  'question' => null
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
              </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/questions/question.blade.php ENDPATH**/ ?>