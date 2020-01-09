<?php
/**
 * @var string name
 * @var bool $isMultiple
 * @var string $placeholder
 * @var array $selected
 */
?>
<div class="form-group">
    <span class="cap">
      <?php if ($selected):?>
        <?php $ids = array_keys($selected); ?>
          <span data-id="<?=implode(",", $ids)?>"><?=implode(", ", $selected)?></span>
      <?php else:?>
        <?=$placeholder?>
      <?php endif; ?>
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

