<?php $__env->startPush('style'); ?>
<?php echo view('livewire-powergrid::assets.styles')->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="card-title"><?php echo e($attendance->title); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo e($attendance->description); ?></h6>
                <div class="d-flex align-items-center gap-2">
                    <?php echo $__env->make('partials.attendance-badges', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <a href="<?php echo e(route('presences.permissions', $attendance->id)); ?>" class="badge text-bg-info">Karyawaan
                        Izin</a>
                    <a href="<?php echo e(route('presences.not-present', $attendance->id)); ?>" class="badge text-bg-danger">Alfa</a>
                    <?php if($attendance->code): ?>
                    <a href="<?php echo e(route('presences.qrcode', ['code' => $attendance->code])); ?>"
                        class="badge text-bg-success">QRCode</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <small class="fw-bold text-muted d-block">Range Jam Masuk</small>
                            <span><?php echo e($attendance->start_time); ?> - <?php echo e($attendance->batas_start_time); ?></span>
                        </div>
                        <div class="mb-2">
                            <small class="fw-bold text-muted d-block">Range Jam Pulang</small>
                            <span><?php echo e($attendance->end_time); ?> - <?php echo e($attendance->batas_end_time); ?></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-2">
                            <small class="fw-bold text-muted d-block">Jabatan / Posisi</small>
                            <div>
                                <?php $__currentLoopData = $attendance->positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge text-bg-success d-inline-block me-1"><?php echo e($position->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('presence-table', ['attendanceId' => ''.e($attendance->id).''])->html();
} elseif ($_instance->childHasBeenRendered('a0jBCNA')) {
    $componentId = $_instance->getRenderedChildComponentId('a0jBCNA');
    $componentTag = $_instance->getRenderedChildComponentTagName('a0jBCNA');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('a0jBCNA');
} else {
    $response = \Livewire\Livewire::mount('presence-table', ['attendanceId' => ''.e($attendance->id).'']);
    $html = $response->html();
    $_instance->logRenderedChild('a0jBCNA', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('jquery/jquery-3.6.0.min.js')); ?>"></script>
<?php echo view('livewire-powergrid::assets.scripts')->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/presences/show.blade.php ENDPATH**/ ?>