<?php

use App\Html;
use App\Models\Device;
use App\Params;

/**
 * @var $devices Device[]
 * @var $totalCount int
 * @var $params array
 * @var $offset int
 */
 ?>
<h2 class="page-title dr-h2">Девайсы</h2>

<?=Html::renderPaginator([
    'page' => $params[Params::PAGE],
    'per_page' => $params[Params::PER_PAGE],
    'total_count' => $totalCount,
])?>

<div class="table" id="horizontal-scroller">
  <div class="table-content">
    <?php echo $this->render('table_head'); ?>
    <?php echo $this->render('table_body', compact('devices', 'offset')); ?>
  </div>
</div>

<?=Html::renderPaginator([
    'page' => $params[Params::PAGE],
    'per_page' => $params[Params::PER_PAGE],
    'total_count' => $totalCount,
])?>