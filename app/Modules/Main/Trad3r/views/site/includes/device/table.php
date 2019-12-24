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

  <div class="table" id="horizontal-scroller">
    <div class="table-content">
      <?php echo $this->render('table_head'); ?>
      <?php echo $this->render('table_body', compact('devices', 'offset')); ?>
    </div>
  </div>
  <div class="table-btn-tool">
    <button id="new-device" type="button" class="btn btn-primary">
      <span class="icon">
        <svg width="12" height="13" viewBox="0 0 12 13" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.99951 5.229H11.5591V7.19434H6.99951V12.3604H4.91064V7.19434H0.351074V5.229H4.91064V0.456055H6.99951V5.229Z" fill="white"/>
        </svg>
      </span>
      <span class="btn-text">Новая запись</span>
    </button>
    <?=Html::renderPaginator([
      'page' => $params[Params::PAGE],
      'per_page' => $params[Params::PER_PAGE],
      'total_count' => $totalCount,
    ])?>
  </div>
</div>
