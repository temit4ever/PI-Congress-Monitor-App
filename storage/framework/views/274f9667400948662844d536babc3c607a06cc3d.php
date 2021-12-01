<?php $__env->startComponent('mail::message'); ?>
# Welcome!!! <?php echo e($user->firstname); ?>  <?php echo e($user->lastname); ?>

You have been registered to use the platform. Your login credentials are listed below<br>
Email: <?php echo e($user->email); ?><br>
Password: <?php echo e($user->password); ?><br>
<a href="https://leica.local/login">Click here to login</a><br>
Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /Users/tayo/Sites/localhost/projects/leica/resources/views/emails/welcome.blade.php ENDPATH**/ ?>