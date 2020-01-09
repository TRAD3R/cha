<?php

use App\Helpers\HtmlHelper;
use App\Helpers\TextHelper;
use App\Html;
use App\Models\Device;
use App\Params;
use App\Tables\DeviceTableStructure;
use yii\bootstrap\Button;
use yii\debug\widgets\NavigationButton;
use yii\web\View;

/**
 * @var View $this
 * @var Device[] $devices 
 * @var int $totalCount
 * @var array $params
 * @var int $offset
 * @var array $models
 */
 ?>
<div class="page page-devices">

  <div class="search-select">
    <?php echo $this->render("@layouts/common/search_select", ["list"=> $models, 'showReset' => $params[Params::GADGET]]); ?>
  </div>

  <div class="table" id="horizontal-scroller">
    <div class="table-content">
      <?php echo $this->render('table_head', [
              'sortedColumnsAsc' => $params[Params::SORT_ASC], 
              'sortedColumnsDesc' =>$params[Params::SORT_DESC],
      ]); ?>
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
      <span class="btn-text"><?=TextHelper::upperFirstChar(Yii::t('front', 'ADD_NEW_ROW'))?></span>
    </button>
    <?=Html::renderPaginator([
      'page' => $params[Params::PAGE],
      'per_page' => $params[Params::PER_PAGE],
      'total_count' => $totalCount,
    ])?>
  </div>
</div>