<?php $__env->startSection('title', 'Ответы'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-container">
  <div class="admin-header">
    <h1>Ответы</h1>
  </div>

  <a href="/admin" class="back-link">Назад в админку</a>

  <?php if(session('_flash.success')): ?>
    <div class="flash-message flash-success"><?php echo e(session('_flash.success')); ?></div>
  <?php endif; ?>
  <?php if(session('_flash.error')): ?>
    <div class="flash-message flash-error"><?php echo e(session('_flash.error')); ?></div>
  <?php endif; ?>

  <form method="get" action="/admin/answers" class="search-form">
    <input type="text" name="search" placeholder="Поиск по содержимому ответа" value="<?php echo e(request('search')); ?>">
    <select name="status">
      <option value="">Все статусы</option>
      <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Черновик</option>
      <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Опубликован</option>
      <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Отклонен</option>
    </select>
    <button type="submit" class="btn btn-primary">Поиск</button>
  </form>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Вопрос</th>
        <th>Автор</th>
        <th>Статус</th>
        <th>Действие</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($answer->id); ?></td>
        <td><?php echo e($answer->question->title ?? '-'); ?></td>
        <td><?php echo e($answer->author->name ?? '-'); ?></td>
        <td><span class="status-<?php echo e($answer->status); ?>"><?php echo e($answer->status); ?></span></td>
        <td>
          <form method="post" action="/admin/answers/<?php echo e($answer->id); ?>/delete" style="display:inline">
            <?php echo csrf_field(); ?>

            <button type="submit" class="btn btn-danger">Удалить</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>

  <?php echo e($answers->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/admin/src/Providers/../Resources/views/answers.blade.php ENDPATH**/ ?>