<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'theme' => '',
    'inline' => null,
    'multiSelect' => null,
    'column' => null,
    'tableName' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'theme' => '',
    'inline' => null,
    'multiSelect' => null,
    'column' => null,
    'tableName' => null,
]); ?>
<?php foreach (array_filter(([
    'theme' => '',
    'inline' => null,
    'multiSelect' => null,
    'column' => null,
    'tableName' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div x-cloak
     wire:ignore
     x-data="pgMultiSelectBs5({
        tableName: '<?php echo e($tableName); ?>',
        dataField: '<?php echo e($multiSelect['dataField']); ?>',
    })">
    <?php if(filled($multiSelect)): ?>
        <div class="<?php echo e($theme->baseClass); ?>" style="<?php echo e($theme->baseStyle); ?>">
            <select data-none-selected-text="<?php echo e(trans('livewire-powergrid::datatable.multi_select.select')); ?>"
                    multiple
                    wire:model="filters.multi_select.<?php echo e($multiSelect['dataField']); ?>.values"
                    x-ref="select_picker_<?php echo e($multiSelect['dataField']); ?>"
                    data-live-search="true">
                <option value=""><?php echo e(trans('livewire-powergrid::datatable.multi_select.all')); ?></option>
                <?php $__currentLoopData = data_get($multiSelect, 'data_source'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $key = isset($relation['id']) ? 'id' : 'value';
                        if (isset($relation[$multiSelect['dataField']])) $key = $multiSelect['dataField'];
                    ?>
                    <option value="<?php echo e(data_get($relation, $key)); ?>">
                        <?php echo e($relation[data_get($multiSelect, 'text')]); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\vendor\power-components\livewire-powergrid\src\Providers/../../resources/views/components/frameworks/bootstrap5/filters/multi-select.blade.php ENDPATH**/ ?>