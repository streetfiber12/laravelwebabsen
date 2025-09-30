<?php if(filled(config('livewire-powergrid.plugins.flatpickr.css'))): ?>
<link rel="stylesheet" href="<?php echo e(config('livewire-powergrid.plugins.flatpickr.css')); ?>">
<?php endif; ?>

<?php if(isBootstrap5() && filled(config('livewire-powergrid.plugins.bootstrap-select.css'))): ?>
    <link rel="stylesheet" href="<?php echo e(config('livewire-powergrid.plugins.bootstrap-select.css')); ?>" crossorigin="anonymous"/>
<?php endif; ?>

<?php if(isset($cssPath)): ?>
    <style><?php echo file_get_contents($cssPath); ?></style>
<?php endif; ?>

<?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\vendor\power-components\livewire-powergrid\src\Providers/../../resources/views/assets/styles.blade.php ENDPATH**/ ?>