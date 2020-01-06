<?php


use App\Params;
use App\Tables\DeviceTableStructure;

/**
 * @var array $sortedColumnsAsc
 * @var array $sortedColumnsDesc
 */
$ths = DeviceTableStructure::getTitles();
$sortedColumns = DeviceTableStructure::getSortedColumns();
?>

<div class="table-head">
  <div class="table-row">
    <?php foreach ($ths as $groupKey => $group):?>
<!--      <div class="table-group gr---><?//=$key ?><!--">-->
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
<!--                <div class="column-tool-group">-->
<!--                  <div class="column-tool-header">-->
<!--                    <div class="icon">-->
<!--                      <svg width="16" height="10" viewBox="0 0 16 10" xmlns="http://www.w3.org/2000/svg">-->
<!--                        <path d="M6.33333 10H9.66667V8.33333H6.33333V10ZM0.5 0V1.66667H15.5V0H0.5ZM3 5.83333H13V4.16667H3V5.83333Z" fill="inherit"/>-->
<!--                      </svg>-->
<!--                    </div>-->
<!--                    <span>Фильтрация</span>-->
<!--                  </div>-->
<!--                  <div class="column-tool-body">-->
<!--                    <div class="column-tool-total">-->
<!--                      <button type="button" class="btn-select-all">Выбрать все</button>-->
<!--                      <button type="button" class="btn-remove-all disabled">Убрать все</button>-->
<!--                    </div>-->
<!--                    <ul class="column-tool-list">-->
<!--                      <li>-->
<!--                        <label class="checkbox">-->
<!--                          <input type="checkbox" />-->
<!--                          <span class="checkbox-box">-->
<!--                            <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">-->
<!--                            <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>-->
<!--                            </svg>-->
<!--                          </span>-->
<!--                          <span class="checkbox-text">Пункт 1</span>-->
<!--                        </label>-->
<!--                      </li>-->
<!--                      <li>-->
<!--                        <label class="checkbox">-->
<!--                          <input type="checkbox" checked/>-->
<!--                          <span class="checkbox-box">-->
<!--                            <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">-->
<!--                            <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>-->
<!--                            </svg>-->
<!--                          </span>-->
<!--                          <span class="checkbox-text">Пункт 2</span>-->
<!--                        </label>-->
<!--                      </li>-->
<!--                      <li>-->
<!--                        <label class="checkbox">-->
<!--                          <input type="checkbox" checked/>-->
<!--                          <span class="checkbox-box">-->
<!--                            <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">-->
<!--                            <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>-->
<!--                            </svg>-->
<!--                          </span>-->
<!--                          <span class="checkbox-text">Пункт 3</span>-->
<!--                        </label>-->
<!--                      </li>-->
<!--                      <li>-->
<!--                        <label class="checkbox">-->
<!--                          <input type="checkbox" checked/>-->
<!--                          <span class="checkbox-box">-->
<!--                            <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">-->
<!--                            <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>-->
<!--                            </svg>-->
<!--                          </span>-->
<!--                          <span class="checkbox-text">Пункт 3</span>-->
<!--                        </label>-->
<!--                      </li>-->
<!--                      <li>-->
<!--                        <label class="checkbox">-->
<!--                          <input type="checkbox" checked/>-->
<!--                          <span class="checkbox-box">-->
<!--                            <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">-->
<!--                            <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>-->
<!--                            </svg>-->
<!--                          </span>-->
<!--                          <span class="checkbox-text">Пункт 3</span>-->
<!--                        </label>-->
<!--                      </li>-->
<!--                      <li>-->
<!--                        <label class="checkbox">-->
<!--                          <input type="checkbox" checked/>-->
<!--                          <span class="checkbox-box">-->
<!--                            <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">-->
<!--                            <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>-->
<!--                            </svg>-->
<!--                          </span>-->
<!--                          <span class="checkbox-text">Пункт 3</span>-->
<!--                        </label>-->
<!--                      </li>-->
<!--                    </ul>-->
<!--                  </div>-->
<!--                </div>-->
<!--                <div class="column-tool-btns">-->
<!--                  <button class="btn btn-muted btn-filter-cancel">Отмена</button>-->
<!--                  <button class="btn btn-primary btn-filter-apply">Применить</button>-->
<!--                </div>-->
              </div>
            </div>
            <?php endif;?>
          </div>
        <?php endforeach; ?>
<!--      </div>-->
    <?php endforeach; ?>
  </div>
</div>
