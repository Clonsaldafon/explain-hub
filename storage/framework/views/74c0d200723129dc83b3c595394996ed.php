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
        <?php if(auth()->role() === 'admin'): ?>
          <a
            class="button"
            href="/admin"
          >
            <span>Админ-панель</span>
            <svg
              width="24" height="24" viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M17 17q.625 0 1.063-.437T18.5 15.5t-.437-1.062T17 14t-1.062.438T15.5 15.5t.438 1.063T17 17m0 3q.775 0 1.425-.363t1.05-.962q-.55-.325-1.175-.5T17 18t-1.3.175t-1.175.5q.4.6 1.05.963T17 20m-5 2q-3.475-.875-5.738-3.988T4 11.1V6.375q0-.625.363-1.125t.937-.725l6-2.25q.35-.125.7-.125t.7.125l6 2.25q.575.225.938.725T20 6.375v4.3q-.475-.2-.975-.363T18 10.076V6.4l-6-2.25L6 6.4v4.7q0 1.175.313 2.35t.875 2.238T8.55 17.65t1.775 1.5q.275.8.725 1.525t1.025 1.3q-.025 0-.037.013T12 22m5 0q-2.075 0-3.537-1.463T12 17t1.463-3.537T17 12t3.538 1.463T22 17t-1.463 3.538T17 22m-5-10.35"
              />
            </svg>
          </a>
        <?php endif; ?>
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
        <a
          class="button button--outlined"
          href="/my-answers"
        >
          Мои ответы
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
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/questions/questions.blade.php ENDPATH**/ ?>