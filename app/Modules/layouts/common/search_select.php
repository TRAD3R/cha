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
<div class="search-select-container">
  <input type="text"
         class="search-select-input is-active"
         placeholder="<?=TextHelper::upperFirstChar(Yii::t('front', 'GADGET_SEARCH'))?>">
  <div class="search-select-results is-active">
    <ul class="search-select-list">
      <?php foreach ($list as $item): ?>
        <li class="selected" value="<?=$item['id']?>"><?=$item['title']?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
