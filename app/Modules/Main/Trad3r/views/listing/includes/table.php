<?php

use App\Helpers\ListingHelper;
use App\Helpers\TextHelper;
use App\Html;
use App\Params;
use yii\web\View;

/**
 * @var View $this
 * @var array $gadgets
 * @var int $totalCount
 * @var array $params
 * @var int $offset
 */
?>


<div class="page page-listing">
    <div class="search-select">
        <?php
        if($params[Params::LISTING_TYPE] === ListingHelper::DEVICES) {
            echo $this->render("@layouts/common/search_select", [
                    'showReset' => $params[Params::GADGET],
                    'urlReset' => '/listings?' . Params::LISTING_TYPE . "=" . ListingHelper::DEVICES,
                    'selected' => $selected,
                ]
            );
        }
        ?>
    </div>
    
    <div class="table" id="horizontal-scroller">
        <div class="table-content">
            <?php echo $this->render('table_head', [
                'sortedColumnsAsc' => $params[Params::SORT_ASC],
                'sortedColumnsDesc' =>$params[Params::SORT_DESC],
                'params' => $params,
            ]); ?>
            <?php echo $this->render('table_body', [
                'products' => $gadgets,
            ]); ?>
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
                <span class="btn-text"><?=Yii::t('front', 'LISTING_TYPE')?></span>
                <div class="dropdown-list">
                    <ul>
                        <li class="dropdown-list-item <?=($params[Params::LISTING_TYPE]==ListingHelper::PRODUCTS)?'is-active':'';  ?>">
                            <button id="listing-to-product" type="button">
                                <a href="?<?=Params::LISTING_TYPE.'='.ListingHelper::PRODUCTS?>">
                                    <?=Yii::t('front', 'PRODUCTS')?>
                                </a>
                            </button>
                        </li>
                        <li class="dropdown-list-item <?=($params[Params::LISTING_TYPE]==ListingHelper::DEVICES)?'is-active':'';  ?>">
                            <button id="listing-to-device" type="button">
                                <a href="?<?=Params::LISTING_TYPE.'='.ListingHelper::DEVICES?>">
                                    <?=Yii::t('front', 'DEVICES')?>
                                </a>
                            </button>
                        </li>
                        <li class="dropdown-list-item <?=($params[Params::LISTING_TYPE]==ListingHelper::LINES)?'is-active':'';  ?>">
                            <button id="listing-to-line" type="button">
                                <a href="?<?=Params::LISTING_TYPE.'='.ListingHelper::LINES?>">
                                    <?=Yii::t('front', 'LINE')?>
                                </a>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn btn-light" onclick="showArchive()">
        <span class="icon">
          <svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M21.4811 6.67352V19.6735H3.48108V6.67352" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M23.4811 1.67352H1.48108V6.67352H23.4811V1.67352Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M10.4811 10.6735H14.4811" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </span>
                <span class="btn-text" ><?=Yii::t('front', 'ARCHIVE')?></span>
            </button>
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
        <a href="#" class="showed-listing-file"></a>
    </div>
</div>