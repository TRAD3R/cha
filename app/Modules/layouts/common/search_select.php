<?php
/**
* @var array $list
 */
?>

<select class="chosen-select" size="4"
        data-placeholder="Бренд Модель" style="display: none;">
  <?php foreach ($list as $item) : ?>
    <option value="<?=$item['id']?>"><?=$item['title'] ?></option>
  <?endforeach; ?>
</select>