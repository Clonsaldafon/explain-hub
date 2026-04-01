<?php $__env->startSection('title', 'Пользователи'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-container">
  <div class="admin-header">
    <h1>Пользователи</h1>
  </div>

  <a href="/admin" class="back-link">Назад в админку</a>

  <?php if(session('_flash.success')): ?>
    <div class="flash-message flash-success"><?php echo e(session('_flash.success')); ?></div>
  <?php endif; ?>
  <?php if(session('_flash.error')): ?>
    <div class="flash-message flash-error"><?php echo e(session('_flash.error')); ?></div>
  <?php endif; ?>

  <form method="get" action="/admin/users" class="search-form">
    <input type="text" name="search" placeholder="Поиск по имени или email" value="<?php echo e(request('search')); ?>">
    <select name="role">
      <option value="">Все роли</option>
      <option value="user" <?php echo e(request('role') == 'user' ? 'selected' : ''); ?>>Пользователь</option>
      <option value="editor" <?php echo e(request('role') == 'editor' ? 'selected' : ''); ?>>Редактор</option>
      <option value="moderator" <?php echo e(request('role') == 'moderator' ? 'selected' : ''); ?>>Модератор</option>
      <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Администратор</option>
    </select>
    <select name="blocked">
      <option value="">Все статусы</option>
      <option value="0" <?php echo e(request('blocked') == '0' ? 'selected' : ''); ?>>Не заблокирован</option>
      <option value="1" <?php echo e(request('blocked') == '1' ? 'selected' : ''); ?>>Заблокирован</option>
    </select>
    <button type="submit" class="btn btn-primary">Поиск</button>
  </form>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Заблокирован</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($user->id); ?></td>
        <td><?php echo e($user->name); ?></td>
        <td><?php echo e($user->email); ?></td>
        <td><?php echo e($user->role); ?></td>
        <td><?php echo e($user->is_blocked ? 'Да' : 'Нет'); ?></td>
        <td>
          <a href="/admin/users/<?php echo e($user->id); ?>/edit" class="btn btn-secondary">Редактировать</a>
          <?php if(!$user->is_blocked && !$user->isAdmin()): ?>
            <form method="post" action="/admin/users/<?php echo e($user->id); ?>/ban" style="display:inline">
              <?php echo csrf_field(); ?>

              <button type="submit" class="btn btn-danger">Блокировать</button>
            </form>
          <?php elseif($user->is_blocked): ?>
            <form method="post" action="/admin/users/<?php echo e($user->id); ?>/unban" style="display:inline">
              <?php echo csrf_field(); ?>

              <button type="submit" class="btn btn-success">Разблокировать</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>

  <?php echo e($users->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/anton-bezmelnitsin/Рабочий стол/explain-hub/packages/admin/src/Providers/../Resources/views/users.blade.php ENDPATH**/ ?>