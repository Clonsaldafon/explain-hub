<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-container">
  <div class="admin-header">
    <h1>Админ-панель</h1>
    <a href="/questions">Назад</a>
  </div>

  <div class="admin-stats">
    <div class="stat-card">
      <h3>Всего пользователей</h3>
      <p class="number"><?php echo e($totalUsers); ?></p>
    </div>
    <div class="stat-card">
      <h3>Заблокировано</h3>
      <p class="number"><?php echo e($blockedUsers); ?></p>
    </div>
    <div class="stat-card">
      <h3>Всего вопросов</h3>
      <p class="number"><?php echo e($totalQuestions); ?></p>
    </div>
    <div class="stat-card">
      <h3>Всего ответов</h3>
      <p class="number"><?php echo e($totalAnswers); ?></p>
    </div>
  </div>

  <div class="admin-nav">
    <a href="/admin/users">Управление пользователями</a>
    <a href="/admin/questions">Управление вопросами</a>
    <a href="/admin/answers">Управление ответами</a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/admin/src/Providers/../Resources/views/dashboard.blade.php ENDPATH**/ ?>