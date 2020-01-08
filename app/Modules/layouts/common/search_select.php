<?php
/**
* @var array $list
 */

use App\Helpers\TextHelper; 
?>

<select id="device-model" class="chosen-select"
        size="4"
        data-placeholder="<?=TextHelper::upperFirstChar(Yii::t('front', 'GADGET_SEARCH'))?>"
        style="display: none;"
>
  <?php foreach ($list as $item): ?>
    <option value="<?=$item['id']?>"><?=$item['title']?></option>
  <?php endforeach; ?>
</select>
