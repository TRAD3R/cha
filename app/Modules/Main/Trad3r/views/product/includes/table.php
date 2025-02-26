<?php

use App\Helpers\TextHelper;
use App\Html;
use App\Models\Product;
use App\Params;
use yii\web\View;

/**
 * @var View $this
 * @var Product[] $products 
 * @var int $totalCount
 * @var array $params
 * @var int $offset
 */
 ?>
<div class="page page-product">

  <div class="table" id="horizontal-scroller">
    <div class="table-content">
      <?php echo $this->render('table_head', [
              'sortedColumnsAsc' => $params[Params::SORT_ASC], 
              'sortedColumnsDesc' =>$params[Params::SORT_DESC]
      ]); ?>
      <?php echo $this->render('table_body', compact('products', 'offset')); ?>
    </div>
  </div>
  <div class="table-btn-tool">
    <div class="table-btn-tool__item new-row">
      <div id="new-device" class="btn btn-primary dropdown">
        <span class="icon no-transform">
          <svg width="12" height="13" viewBox="0 0 12 13" xmlns="http://www.w3.org/2000/svg">
          <path d="M6.99951 5.229H11.5591V7.19434H6.99951V12.3604H4.91064V7.19434H0.351074V5.229H4.91064V0.456055H6.99951V5.229Z" fill="white"/>
          </svg>
        </span>
        <span class="btn-text"><?=TextHelper::upperFirstChar(Yii::t('front', 'ADD_NEW_ROW'))?></span>
        <div class="dropdown-list">
          <ul>
            <li class="dropdown-list-item"><button id="new-product-parent" type="button"><?=TextHelper::upperFirstChar(Yii::t('front', 'PARENT'))?></button></li>
            <li class="dropdown-list-item"><button id="new-product-child" type="button"><?=TextHelper::upperFirstChar(Yii::t('front', 'CHILD'))?></button></li>
            <li class="dropdown-list-item"><button id="new-product-individual" type="button"><?=TextHelper::upperFirstChar(Yii::t('front', 'INDIVIDUAL'))?></button></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="table-btn-tool__item">
      <?=Html::renderPaginator([
        'page' => $params[Params::PAGE],
        'per_page' => $params[Params::PER_PAGE],
        'total_count' => $totalCount,
      ])?>
    </div>
  </div>
</div>