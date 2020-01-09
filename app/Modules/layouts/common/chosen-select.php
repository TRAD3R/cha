<?php
/**
 * @var string name
 * @var bool $isMultiple
 * @var string $placeholder
 */
?>
<div class="form-group">
    <span class="text cap">
        <?=$placeholder?>
    </span>
    <select 
        class="form-control" 
        name="<?=$name?> 
        <?php if ($isMultiple):?>
            []" multiple="multiple"
        <?php else:?>
            " 
        <?php endif; ?>
        size="4" 
        data-placeholder="Тип устройства" 
        style="display: none;"
    >
    </select>
</div>

