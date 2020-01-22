<?php
/**
 * @var string $selected
 * @var bool  $showReset
 * @var string $urlReset
 */

use App\Helpers\HtmlHelper;
use App\Helpers\TextHelper;

?>

<?php
if($showReset) {
    echo HtmlHelper::resetButton($urlReset);
}
?>
<div class="search-select-container">
  <input type="text"
         class="search-select-input <?=$selected? 'is-active': ''?>"
         placeholder="<?=TextHelper::upperFirstChar(Yii::t('front', 'GADGET_SEARCH'))?>"
         <?php if($selected):?>
            value="<?=$selected?>"
         <?php endif; ?>
  >
  <div class="search-select-results">
    <ul class="search-select-list">
    </ul>
  </div>
</div>
