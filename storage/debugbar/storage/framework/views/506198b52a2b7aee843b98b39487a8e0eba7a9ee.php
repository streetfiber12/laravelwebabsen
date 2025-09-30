<?php if(session()->has('success')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php if(session()->has('failed')): ?>
<div class="alert alert-danger" role="alert">
    <?php echo e(session('failed')); ?>

</div>
<?php endif; ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/partials/alerts.blade.php ENDPATH**/ ?>