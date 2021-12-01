<?php $__env->startComponent('mail::message'); ?>
# Welcome!!! <?php echo e($user->firstname); ?>  <?php echo e($user->lastname); ?>

You have been register as an admin to use the platform. You log in credential are listed below<br>
Email: <?php echo e($user->email); ?><br>
Password: <?php echo e($user->password); ?><br>
<a href="https://leica.local/login">Click here to login</a><br>
Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/tayo/Sites/localhost/projects/leica/resources/views/emails/welcome.blade.php ENDPATH**/ ?>