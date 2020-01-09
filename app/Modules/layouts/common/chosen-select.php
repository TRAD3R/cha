<?php
/**
 * @var string name
 * @var bool $isMultiple
 * @var string $placeholder
 * @var array $selected
 */
?>
<div class="form-group">
    <span class="text cap">
        <?php if ($selected):?>
            <?php foreach ($selected as $key => $value):?>
                <b data-id="<?=$key?>"><?=$value?></b>
            <?php endforeach?>
        <?php else:?>
            <?=$placeholder?>
        <?php endif; ?>
    </span>
    <select 
        class="form-control hidden-el"
        name="<?=$name?>"
        <?php if ($isMultiple):?>
            multiple="multiple"
        <?php endif; ?>
        size="4" 
        data-placeholder="<?=$placeholder?>" 
    >
    </select>
</div>

