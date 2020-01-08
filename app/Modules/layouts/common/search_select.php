<?php
/**
* @var array $list
* @var bool  $showReset
 */

use App\Helpers\HtmlHelper;
use App\Helpers\TextHelper;

?>

<?php
if($showReset) {
    echo HtmlHelper::resetButton('/devices');
}
?>
<select id="device-model"
        size="4"
        data-placeholder="<?=TextHelper::upperFirstChar(Yii::t('front', 'GADGET_SEARCH'))?>"
        style="display: none;"
>
  <?php foreach ($list as $item): ?>
    <option value="<?=$item['id']?>"><?=$item['title']?></option>
  <?php endforeach; ?>
</select>
