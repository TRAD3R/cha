<?php


use App\Params;
use App\Tables\DeviceTableStructure;
use yii\web\View;

/**
 * @var View $this
 * @var array $sortedColumnsAsc
 * @var array $sortedColumnsDesc
 * @var array $brands
 * @var array $models
 */
$ths = DeviceTableStructure::getTitles();
$sortedColumns = DeviceTableStructure::getSortedColumns();
?>

<div class="table-head">
  <div class="table-row">
    <?php foreach ($ths as $groupKey => $group):?>
        <?php foreach ($group as $key => $th):?>
        <?php $isSortedColumn = in_array($key, array_merge($sortedColumnsAsc, $sortedColumnsDesc)); ?>
          <div class="group-cell gr-<?=$groupKey?> table-cell">
            <span><?=Yii::t('front', $th);?></span>
            <?php if (in_array($key, $sortedColumns)): ?>
                <?=$this->render('@layouts/common/sort', compact('isSortedColumn', 'key', 'sortedColumnsAsc', 'sortedColumnsDesc'))?>
            <?php endif;?>
          </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
  </div>
</div>
