<?php

use App\Params;
use yii\web\View;

/**
 * @var View $this
 * @var int $key
 * @var array $sortedColumns
 * @var array $sortedColumnsAsc
 * @var array $sortedColumnsDesc
 * @var string $groupKey
 * @var string $th
 */

$isSortedColumn = in_array($key, array_merge($sortedColumnsAsc, $sortedColumnsDesc));
?>

<div class="group-cell gr-<?=$groupKey?> table-cell">
    <span><?=Yii::t('front', $th);?></span>
    <?php if (in_array($key, $sortedColumns)): ?>
        <?=$this->render('@layouts/common/sort', compact('isSortedColumn', 'key', 'sortedColumnsAsc', 'sortedColumnsDesc'))?>
    <?php endif;?>
</div>
