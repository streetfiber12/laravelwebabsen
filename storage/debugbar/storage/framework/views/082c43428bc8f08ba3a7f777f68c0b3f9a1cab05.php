<div>
    <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['me-1' => $loop->last, 'btn-group']) ?>">
        <?php echo $__env->renderWhen($action->can, 'livewire-powergrid::components.actions-header', [
            'action' => $action
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\vendor\power-components\livewire-powergrid\src\Providers/../../resources/views/components/frameworks/bootstrap5/header/actions.blade.php ENDPATH**/ ?>