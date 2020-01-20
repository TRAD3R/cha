<?php
/**
 * @var array $list
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
  <input type="text" class="search-select-input" placeholder="Найти девайс">
  <div class="search-select-results">
    <ul class="search-select-list">
      <li>Пункт поиска №1</li>
      <li>Пункт поиска №2</li>
      <li>Пункт поиска №3</li>
    </ul>
  </div>
</div>
<select id="device-model"
        size="4"
        data-placeholder="<?=TextHelper::upperFirstChar(Yii::t('front', 'GADGET_SEARCH'))?>"
        style="display: none;"
>
  <?php foreach ($list as $item): ?>
    <option value="<?=$item['id']?>"><?=$item['title']?></option>
  <?php endforeach; ?>
</select>
