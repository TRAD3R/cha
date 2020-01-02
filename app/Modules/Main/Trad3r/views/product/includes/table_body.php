<?php 
/** 
 * @var $this View
 * @var $devices Device[]
 * @var $device Device 
 * @var $offset int 
 */

use App\Models\Product;
use App\Models\ProductSpecification;
use yii\web\View;

?>
<div class="table-body-wrapper">
    <div id="empty-row" class="table-row hidden-el" data-id="0">
        <?=$this->render('table_row', [
            'product' => new Product(),
            'sequenceNumber' => 0
        ])?>
    </div>
  <div class="table-body">
<!--    --><?php //foreach ($devices as $key => $device):?>
<!--          --><?php
//              $sequenceNumber = ++$key + $offset;
//          ?>
<!--    -->
<!--          <div class="table-row" data-id="--><?//=$device->id?><!--">-->
<!--            --><?//=$this->render('table_row', compact('device', 'sequenceNumber'))?>
<!--          </div>-->
<!--    --><?php //endforeach; ?>


    <div class="table-row" data-id="1">
      <div class="btn-box-wrapper"></div>
      <div class="btn-operations">
        <div class="btn-operations-edit">

        </div>
      </div>
      <div class="table-cell sequence-number">
        1
      </div>
      <div class="table-cell">12.10.2019</div>
      <div class="table-cell editable select" data-id="1">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">Parent</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell">

      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">MicroUSB</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">Dropshipping</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">Dropshipping</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">Dropshipping</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">Dropshipping</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="13">
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="13">
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="13">
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="13">
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="1">
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="123">
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="123">
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell">
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
      </div>
      <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="364921031">
      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">EAN</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell editable text" data-id="6">
        <input class="input-text" type="text" value="364921031">
      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">PhoneAccessory</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
      <div class="table-cell">
        <div class="simple-select">
          <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
            <input hidden type="text" name="sort-view" value="1" data-default-value="1">
            <p class="simple-select-selected" data-placeholder="1">SizeName</p>
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
            </svg>
          </div>
          <div class="simple-select-drop">
            <div class="simple-select-drop-inner">
            </div>
            <div class="simple-select-add">
              <button type="button" class="btn btn-primary" onclick="showModal(this)">Добавить</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>



