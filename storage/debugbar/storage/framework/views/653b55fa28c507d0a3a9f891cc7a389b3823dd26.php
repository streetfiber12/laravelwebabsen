<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('base'); ?>

<?php echo $__env->make('partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container-fluid">
    <div class="row">
        <?php echo $__env->make('partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?php echo e($title); ?></h1>
                
                <?php echo $__env->yieldContent('buttons'); ?>
            </div>

            <div class="py-4">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>