<?php $__env->startSection('title', 'Редактировать пользователя'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-container">
  <div class="admin-header">
    <h1>Редактировать пользователя</h1>
  </div>

  <a href="/admin/users" class="back-link">Назад к пользователям</a>

  <?php if(session('_flash.success')): ?>
    <div class="flash-message flash-success"><?php echo e(session('_flash.success')); ?></div>
  <?php endif; ?>
  <?php if(session('_flash.error')): ?>
    <div class="flash-message flash-error"><?php echo e(session('_flash.error')); ?></div>
  <?php endif; ?>

  <form method="post" action="/admin/users/<?php echo e($user->id); ?>/update" class="admin-form">
    <?php echo csrf_field(); ?>

    <div class="form-group">
      <label for="name">Имя</label>
      <input type="text" id="name" name="name" value="<?php echo e($user->name); ?>" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo e($user->email); ?>" required>
    </div>
    <div class="form-group">
      <label for="role">Роль</label>
      <select id="role" name="role" required>
        <option value="user" <?php echo e($user->role == 'user' ? 'selected' : ''); ?>>Пользователь</option>
        <option value="editor" <?php echo e($user->role == 'editor' ? 'selected' : ''); ?>>Редактор</option>
        <option value="moderator" <?php echo e($user->role == 'moderator' ? 'selected' : ''); ?>>Модератор</option>
        <option value="admin" <?php echo e($user->role == 'admin' ? 'selected' : ''); ?>>Администратор</option>
      </select>
    </div>
    <div class="form-group">
      <label for="is_blocked">Заблокирован</label>
      <input type="checkbox" id="is_blocked" name="is_blocked" value="1" <?php echo e($user->is_blocked ? 'checked' : ''); ?>>
    </div>
    <button type="submit" class="btn btn-primary">Обновить</button>
  </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/admin/src/Providers/../Resources/views/edit_user.blade.php ENDPATH**/ ?>