<?php


use App\Params;
use App\Tables\ListingTableStructure;

/**
 * @var array $sortedColumnsAsc
 * @var array $sortedColumnsDesc
 */
$ths = ListingTableStructure::getTitles();
$sortedColumns = ListingTableStructure::getSortedColumns();
?>

<div class="table-head">
  <div class="table-row">
    <?php foreach ($ths as $groupKey => $group):?>
        <?php foreach ($group as $key => $th):?>
        <?php $isSortedColumn = in_array($key, array_merge($sortedColumnsAsc, $sortedColumnsDesc)); ?>
        
          <div class="group-cell gr-<?=$groupKey?> table-cell">
            <span><?=Yii::t('front', $th);?></span>
            <?php if (in_array($key, $sortedColumns)): ?>
                <button type="button" class="btn btn-box btn-box-min btn-filter-column btn-gray-transparency <?= $isSortedColumn ? 'is-active' : ''?>">
                  <span class="icon">
                    <svg width="16" height="10" viewBox="0 0 16 10" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.33333 10H9.66667V8.33333H6.33333V10ZM0.5 0V1.66667H15.5V0H0.5ZM3 5.83333H13V4.16667H3V5.83333Z" fill="inherit"/>
                    </svg>
                  </span>
                </button>
                <div class="column-tool-dropdown dropdown">
                  <div class="column-tool-dropdown-inner">
                    <div class="column-tool-group">
                      <div class="column-tool-header">
                        <div class="icon">
                          <svg width="16" height="10" viewBox="0 0 16 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.5 10H5.5V8.33333H0.5V10ZM0.5 0V1.66667H15.5V0H0.5ZM0.5 5.83333H10.5V4.16667H0.5V5.83333Z" fill="inherit"/>
                          </svg>
                        </div>
                        <span>Сортировка</span>
                      </div>
                      <div class="column-tool-body">
                        <div class="column-tool-total">
                          <button type="button" class="btn-remove-sort <?= $isSortedColumn ? '' : 'disabled'?>" data-key="<?=$key?>">Убрать сортировку</button>
                        </div>
                        <ul class="column-tool-list">
                          <li><button type="button" class="column-tool-item sort tool-sort-asc <?=in_array($key, $sortedColumnsAsc) ? 'is-active' : ''?>" 
                                      onclick="Gadget.addSort('<?=Params::SORT_ASC?>', <?=$key?>)">
                                  Сортировать от А - Я
                              </button>
                          </li>
                          <li><button type="button" class="column-tool-item sort tool-sort-desc <?=in_array($key, $sortedColumnsDesc) ? 'is-active' : ''?>" 
                                      onclick="Gadget.addSort('<?=Params::SORT_DESC?>', <?=$key?>)">
                                  Сортировать от Я - А
                              </button>
                          </li>
                        </ul>
                      </div>
                    </div>
              </div>
            </div>
            <?php endif;?>
          </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
  </div>
</div>
