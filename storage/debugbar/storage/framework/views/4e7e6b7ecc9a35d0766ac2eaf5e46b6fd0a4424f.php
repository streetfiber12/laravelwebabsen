<div>
    <div class="col-md-12">
        <?php echo $__env->make($theme->layout->header, [
                'enabledFilters' => $enabledFilters
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="<?php echo e($theme->table->divClass); ?>" style="<?php echo e($theme->table->divStyle); ?>">
        <?php echo $__env->make($table, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="row">
        <div class="col-12 overflow-auto">
            <?php echo $__env->make($theme->footer->view, ['theme' => $theme], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\vendor\power-components\livewire-powergrid\src\Providers/../../resources/views/components/frameworks/bootstrap5/table-base.blade.php ENDPATH**/ ?>