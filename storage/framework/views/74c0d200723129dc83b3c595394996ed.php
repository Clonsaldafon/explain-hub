<?php $__env->startSection("content"); ?>
  <section class="questions section container">
    <header class="section__header">
      <div class="questions__search">
        <input
          class="questions__search-input input"
          id="question-search-input"
          name="question"
          type="search"
          placeholder="Поиск..."
        >
        <button
          class="questions__search-button button"
          type="button"
        >
          Найти
        </button>
      </div>
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
    </header>
    <div class="section__body">
      <?php if(auth()->check()): ?>
      <div class="questions__buttons">
        <a
          class="questions__add-button button"
          href="/questions/create"
        >
          <span class="questions__add-button-text">Задать вопрос</span>
          <svg
            class="questions__add-button-icon"
            width="24" height="24" viewBox="0 0 24 24"
          >
            <path
              fill="currentColor"
              d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z"
            />
          </svg>
        </a>
        <a
          class="button button--outlined"
          href="/my-questions"
        >
          Мои вопросы
        </a>
      </div>
      <?php else: ?>
        <a
          class="questions__add-button questions__add-button--disabled button"
          href="/questions/create"
          title="Войдите в аккаунт"
        >
          <span class="questions__add-button-text">Войдите, чтобы задать вопрос</span>
        </a>
      <?php endif; ?>
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
              'likes' => $question->likes
            ]); ?>
            <?php echo $__env->renderComponent(); ?>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/questions/questions.blade.php ENDPATH**/ ?>