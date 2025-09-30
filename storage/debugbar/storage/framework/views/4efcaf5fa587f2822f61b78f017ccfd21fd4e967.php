<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="row">
    <div class="col-md-7">
        <ul class="list-group">
            <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <a href="<?php echo e(route('presences.show', $attendance->id)); ?>"
                    class="list-group-item d-flex justify-content-between align-items-start py-3">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><?php echo e($attendance->title); ?></div>
                        <p class="mb-0"><?php echo e($attendance->description); ?></p>
                    </div>
                    
                    <?php echo $__env->make('partials.attendance-badges', ['attendance' => $attendance], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/presences/index.blade.php ENDPATH**/ ?>