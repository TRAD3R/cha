<?php

use App\Html;
use App\Models\Device;
use App\Params;
use yii\web\View;

/**
 * @var View $this
 * @var Device[] $devices 
 * @var int $totalCount
 * @var array $params
 * @var int $offset
 */
 ?>
<div class="page page-devices">
  <h2 class="page-title dr-h2">Девайсы</h2>

<!--  --><?//=Html::renderPaginator([
//    'page' => $params[Params::PAGE],
//    'per_page' => $params[Params::PER_PAGE],
//    'total_count' => $totalCount,
//  ])?>

  <div class="table" id="horizontal-scroller">
    <div class="table-content">
      <?php echo $this->render('table_head'); ?>
      <?php echo $this->render('table_body', compact('devices', 'offset')); ?>
    </div>
  </div>
</div>


<?=Html::renderPaginator([
  'page' => $params[Params::PAGE],
  'per_page' => $params[Params::PER_PAGE],
  'total_count' => $totalCount,
])?>