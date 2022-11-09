<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title inertia><?php echo e(config('app.name', 'LEAD')); ?></title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-32x32.png')); ?>" sizes="32x32" />
        <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon-16x16.png')); ?>" sizes="16x16" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">

        <!-- Scripts -->
        <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>
        <script src="<?php echo e(mix('js/app.js')); ?>" defer></script>
    </head>
    <body class="antialiased">
        <div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div>
    </body>
</html>
<?php /**PATH /Users/temit/Documents/Container/PI-Congress-Monitor-App/resources/views/app.blade.php ENDPATH**/ ?>