<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'theme' => '',
    'enabledFilters' => [],
    'column' => null,
    'inline' => null,
    'inputText' => null,
    'inputTextOptions' => [],
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'theme' => '',
    'enabledFilters' => [],
    'column' => null,
    'inline' => null,
    'inputText' => null,
    'inputTextOptions' => [],
]); ?>
<?php foreach (array_filter(([
    'theme' => '',
    'enabledFilters' => [],
    'column' => null,
    'inline' => null,
    'inputText' => null,
    'inputTextOptions' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    <?php
        $field = data_get($inputText, 'dataField') ?? data_get($inputText, 'field');
    ?>
    <?php if(filled($inputText)): ?>
        <div class="<?php echo e($theme->baseClass); ?>" style="<?php echo e($theme->baseStyle); ?>">
            <div class="relative">
                <select class="power_grid <?php echo e($theme->selectClass); ?> <?php echo e(data_get($column, 'headerClass')); ?>"
                        style="<?php echo e(data_get($column, 'headerStyle')); ?>"
                        wire:model.defer="filters.input_text_options.<?php echo e($field); ?>"
                        wire:input.defer="filterInputTextOptions('<?php echo e($field); ?>', $event.target.value, '<?php echo e(data_get($inputText, 'label')); ?>')">
                    <?php $__currentLoopData = $inputTextOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>"><?php echo e(trans($value)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="mt-1">
                <input
                    data-id="<?php echo e($field); ?>"
                    <?php if(isset($enabledFilters[$field]['disabled']) && boolval($enabledFilters[$field]['disabled']) === true): ?> disabled <?php else: ?>
                    wire:model.debounce.800ms="filters.input_text.<?php echo e($field); ?>"
                    wire:input.debounce.800ms="filterInputText('<?php echo e($field); ?>', $event.target.value, '<?php echo e(data_get($inputText, 'label')); ?>')"
                    <?php endif; ?>
                    type="text"
                    class="power_grid <?php echo e($theme->inputClass); ?>"
                    placeholder="<?php echo e(empty($column)?data_get($inputText, 'label'):($column->placeholder?:$column->title)); ?>" />
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\vendor\power-components\livewire-powergrid\src\Providers/../../resources/views/components/frameworks/bootstrap5/filters/input-text.blade.php ENDPATH**/ ?>