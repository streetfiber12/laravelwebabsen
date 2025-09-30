<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'theme' => null
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'theme' => null
]); ?>
<?php foreach (array_filter(([
    'theme' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    <table class="table power-grid-table <?php echo e($theme->tableClass); ?>"
           style="<?php echo e($theme->tableStyle); ?>">
        <thead class="<?php echo e($theme->theadClass); ?>"
               style="<?php echo e($theme->theadStyle); ?>">
                <?php echo e($header); ?>

        </thead>
        <tbody class="<?php echo e($theme->tbodyClass); ?>"
               style="<?php echo e($theme->tbodyStyle); ?>">
                <?php echo e($rows); ?>

        </tbody>
    </table>
</div>
<?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\vendor\power-components\livewire-powergrid\src\Providers/../../resources/views/components/table-base.blade.php ENDPATH**/ ?>