<?php
/** 
 * @var \yii\web\View   $this
 * @var Product[]       $products
 * @var array           $params
 * @var int             $totalCount
 */

use App\Helpers\TextHelper;
use App\Html;
use App\Models\Product;
use App\Params; 

?>
<?php //echo $this->render("@layouts/common/preloader"); ?>
<?php //echo $this->render('includes/table', compact('products', 'totalCount', 'params', 'offset')); ?>

<div class="page page-listing">
  <div class="table" id="horizontal-scroller">
    <div class="table-content">
      <?php echo $this->render('includes/table_head', [
        'sortedColumnsAsc' => $params[Params::SORT_ASC],
        'sortedColumnsDesc' =>$params[Params::SORT_DESC],
      ]); ?>
      <?php echo $this->render('includes/table_body', compact('products', 'offset')); ?>
    </div>
  </div>
  <div class="table-btn-tool">
    <div class="table-btn-tool__item">
      <button id="create-listing" type="button" class="btn btn-primary">
          <span class="icon">
            <svg width="12" height="13" viewBox="0 0 12 13" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.99951 5.229H11.5591V7.19434H6.99951V12.3604H4.91064V7.19434H0.351074V5.229H4.91064V0.456055H6.99951V5.229Z" fill="white"/>
            </svg>
          </span>
        <span class="btn-text"><?=TextHelper::upperFirstChar(Yii::t('front', 'CREATE_LISTING'))?></span>
      </button>
      <div class="btn btn-dark-blue dropdown">
          <span class="icon no-transform">
            <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 19V12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M4 8V1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 19V10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 6V1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 19V14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 10V1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M1 12H7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9 6H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 14H23" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        <span class="btn-text">Тип листинга</span>
        <div class="dropdown-list">
          <ul>
            <li class="dropdown-list-item"><button id="listing-to-product" type="button">Листинг к товару</button></li>
            <li class="dropdown-list-item"><button id="listing-to-device" type="button">Листинг к девайсу</button></li>
            <li class="dropdown-list-item"><button id="listing-to-line" type="button">Листинг к линейкам</li>
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
  <div class="showed-listing">
    <div class="preloader"></div>
    <a href="#" class="showed-listing-file">File listing.xlsx</a>
  </div>
</div>
