<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['id', 'type' => 'text', 'name', 'placeholder' => '', 'required' => true]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['id', 'type' => 'text', 'name', 'placeholder' => '', 'required' => true]); ?>
<?php foreach (array_filter((['id', 'type' => 'text', 'name', 'placeholder' => '', 'required' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<input type="<?php echo e($type); ?>" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" placeholder="<?php echo e($placeholder); ?>" <?php echo e($attributes->merge(['class' => 'form-control'])); ?> <?php echo e($attributes->get('wire')); ?> <?php if($required): ?> required <?php endif; ?> /><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/components/form-input.blade.php ENDPATH**/ ?>