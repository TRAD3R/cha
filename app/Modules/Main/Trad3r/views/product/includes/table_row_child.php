<?php
/**
 * @var $product Product
 * @var $specifications ProductSpecification
 * @var $sequenceNumber int
 */

use App\Helpers\TextHelper;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Tables\ProductTableStructure;

/** @var ProductSpecification $specifications */
$specifications = $product->specifications;
?>

    <div class="btn-box-wrapper"></div>
    <div class="btn-operations">
        <div class="btn-operations-edit">
    
        </div>
    </div>
    <div class="table-cell sequence-number">
        <?=$sequenceNumber?>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::DATE_CREATED?>">
        <?php
        try {
            $dateCreated = new DateTime($specifications->date_created);
            echo $dateCreated->format('d.m.Y');
        } catch (Exception $e) {
        }
        ?>
    </div>
    <div class="table-cell editable" data-id="<?=ProductTableStructure::NODE?>">
        <?php $nodeName = TextHelper::upperFirstChar(Yii::t('front', $product->parent_id ? 'CHILD' : 'PARENT')); ?>
        <div class="simple-select">
            <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
                <input hidden type="text" name="sort-view" value="<?=$product->parent->id;?>" data-default-value="1">
                <p class="simple-select-selected" data-placeholder="<?=$nodeName;?>"><?=$nodeName;?></p>
                <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
                </svg>
            </div>
            <div class="simple-select-drop">
                <div class="simple-select-drop-inner">
                    <ul class="simple-select-list" role="listbox">
                        <li class="simple-select-item <?=$product->parent_id ? '' : 'is-active'?>" role="option" data-value="0">
                            <?=TextHelper::upperFirstChar(Yii::t('front', 'PARENT'));?>
                        </li>
                        <li class="simple-select-item <?=$product->parent_id ? 'is-active' : ''?>" role="option" data-value="1">
                            <?=TextHelper::upperFirstChar(Yii::t('front', 'CHILD'));?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::SKU?>">
        <input class="input-text" type="text" value="<?=$specifications->sku?>">
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::BRAND?>">
        <?php
            echo $this->render('@layouts/common/simple_select', [
                'title' => $specifications->productBrand->name,
                'value' => $specifications->productBrand->id,
            ])
        ?>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::MANUFACTURER?>">
        <div class="simple-select">
            <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
                <input hidden type="text" name="sort-view" value="1" data-default-value="1">
                <p class="simple-select-selected" data-placeholder="1">D-Parts</p>
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
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::LENGTH?>">
        <input class="input-text" type="text" value="13">
    </div>
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::WIDTH?>">
        <input class="input-text" type="text" value="13">
    </div>
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::DEPTH?>">
        <input class="input-text" type="text" value="13">
    </div>
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::SIZE?>">
        <input class="input-text" type="text" value="13">
    </div>
    <div class="table-cell editable select" data-id="5">
        <div class="simple-select">
            <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
                <input hidden type="text" name="sort-view" value="1" data-default-value="1">
                <p class="simple-select-selected" data-placeholder="1">М</p>
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
        <input class="input-text" type="text" value="123">
    </div>
    <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="123">
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
    
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text">
        <textarea class="input-text" hidden>Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</textarea>
        <span class="text">Ladekabel/Datenkabel für (Brand Model)chwarz - 1M</span>
    </div>
    <div class="table-cell editable text" data-id="5">
        <input class="input-text" type="text" value="364921031">
    </div>
    <div class="table-cell editable select">
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
    <div class="table-cell editable select">
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
    <div class="table-cell editable select">
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
