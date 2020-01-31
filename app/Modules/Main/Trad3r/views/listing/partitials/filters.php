<?php
/**
 * @var Product[]   $products
 * @var array      $params
 */

use App\Models\Product;
use App\Params; ?>

<div class="btn btn-product-dropdown dropdown <?=(count($params[Params::PRODUCTS]))?'btn-product-dropdown-active':'' ?>">
    <span class="btn-text">
      <?=Yii::t('front', 'SELECT_PRODUCT', ['count'=>count($params[Params::PRODUCTS])])?>
    </span>
    <span class="icon ml">
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"></path>
            </svg>
          </span>
    <div class="dropdown-list" id="product-list">
        <div class="column-tool-total">
            <button type="button" class="btn-select-all"><?=Yii::t('front', 'SELECT_ALL')?></button>
            <button type="button" class="btn-remove-all disabled"><?=Yii::t('front', 'UNCHECK_ALL')?></button>
        </div>
        <ul>
            <?php foreach ($products as $product): ?>
                <li class="dropdown-list-item">
                    <label class="checkbox">
                        <input type="checkbox" class="product" data-id="<?=$product->id?>"
                            <?= in_array($product->id, $params[Params::PRODUCTS]) ? "checked" : ""?>
                        />
                        <span class="checkbox-box">
                  <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
                  </svg>
                </span>
                        <span class="checkbox-text"><?=$product->title?></span>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="input-date-range">
    <div class="form-group inline-form">
        <label for="date-from"><?=Yii::t('front', 'FROM')?>:</label>
        <input type="date" id="date-start" value="<?=date('Y-m-d', $params[Params::SORT_DATE_FROM])?>">
    </div>
    <div class="form-group inline-form">
        <label for="date-from"><?=Yii::t('front', 'TO')?>:</label>
        <input type="date" id="date-end" value="<?=date('Y-m-d', $params[Params::SORT_DATE_TO])?>">
    </div>
</div>

<button type="button" class="btn btn-primary w-auto" onclick="filterListing()">Фильтр</button>