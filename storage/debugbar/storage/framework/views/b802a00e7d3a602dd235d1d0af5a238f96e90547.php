<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['required' => true, 'label', 'id']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['required' => true, 'label', 'id']); ?>
<?php foreach (array_filter((['required' => true, 'label', 'id']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<label for="<?php echo e($id); ?>" class="form-label fw-bold"><?php echo e($label); ?> <?php if($required): ?> <sup class="text-danger">*</sup>
    <?php endif; ?></label><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/components/form-label.blade.php ENDPATH**/ ?>