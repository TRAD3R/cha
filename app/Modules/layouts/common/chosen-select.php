<?php
/**
 * @var string name
 * @var bool $isMultiple
 * @var string $placeholder
 * @var array $selected
 */
?>
<div class="form-group">
    <span class="cap" title="<?=$placeholder?>">
      <?php if ($selected):?>
        <?php $ids = array_keys($selected); ?>
          <span class="item-selected" data-id="<?=implode(",", $ids)?>"><?=implode(", ", $selected)?></span>
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

