<details class="question-card">
  <summary class="question-card__header question-card__container">
    <div class="question-card__header-info">
      <h3 class="question-card__title h3">
        <?php echo e($title); ?>

      </h3>
      <?php $__env->startComponent('questions::components.tag-list', [
        'tags' => $tags
      ]); ?>
      <?php echo $__env->renderComponent(); ?>
    </div>
    <div class="question-card__header-more">
      <div class="question-card__header-more-item">
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
        <span class="question-card__header-more-text"><?php echo e($views); ?></span>
      </div>
      <div class="question-card__header-more-item">
        <svg
          class="question-card__header-more-icon"
          width="24" height="24" viewBox="0 0 24 24"
        >
          <path
            fill="currentColor"
            d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2M4 10h2v9H4zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7z"
          />
        </svg>
        <span class="question-card__header-more-text"><?php echo e($likes); ?></span>
      </div>
      <span class="question-card__indicator"></span>
    </div>
  </summary>
  <div class="question-card__body question-card__container">
    <p><?php echo e($content); ?></p>
  </div>
  <footer class="question-card__footer question-card__container">
    <div class="helped">
      <input
        class="helped__checkbox"
        id="helped-checkbox-<?php echo e($id ?? uniqid()); ?>"
        name="helped"
        type="checkbox"
      >
      <label class="helped__label" for="helped-checkbox-<?php echo e($id ?? uniqid()); ?>">
        <span class="helped__label-text">Помогло</span>
        <svg
          class="helped__label-icon"
          width="24" height="24" viewBox="0 0 24 24"
        >
          <path
            fill="currentColor"
            d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2M4 10h2v9H4zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7z"
          />
        </svg>
      </label>
    </div>
    <a
      class="button button--transparent"
      href="<?php echo e('/questions/' . $id); ?>"
    >
      <span>Перейти</span>
      <svg
        width="24" height="24" viewBox="0 0 24 24"
      >
        <path
          fill="none" stroke="currentColor"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="m9 5l6 7l-6 7"
        />
      </svg>
    </a>
  </footer>
</details><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/questions/src/Providers/../Resources/views/components/question-card.blade.php ENDPATH**/ ?>