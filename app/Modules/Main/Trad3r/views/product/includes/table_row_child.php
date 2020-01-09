<?php
/**
 * @var $product Product
 * @var $specifications ProductSpecification
 * @var $sequenceNumber int
 */

use App\Helpers\TextHelper;
use App\Models\Buletpoint;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Tables\ProductTableStructure;

/** @var ProductSpecification $specifications */
$specifications = $product->specifications;
?>

    <div class="btn-box-wrapper"></div>
    <div class="table-cell sequence-number">
        <?=$product->id?>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::DATE_CREATED?>">
        <?php
        try {
            $dateCreated = new DateTime($specifications->date_created);
            echo $dateCreated->format('d.m.Y');
        } catch (Exception $e) {
            $e->getMessage();
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
    <div class="table-cell editable" data-id="<?=ProductTableStructure::PARENT_ID?>">
        <?php
            echo $this->render('@layouts/common/simple_select', [
                'title' => $product->parent_id,
                'value' => $product->parent_id,
            ])
        ?>
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
        <?php
            echo $this->render('@layouts/common/simple_select', [
                'title' => $specifications->manufacturer->name,
                'value' => $specifications->manufacturer->id,
            ])
        ?>
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
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::UNIT_MEASURE?>">
        <?php
            echo $this->render('@layouts/common/simple_select', [
                'title' => $specifications->measureUnit->type,
                'value' => $specifications->measure_unit_id,
            ])
        ?>
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::PRICE?>">
        <input class="input-text" type="text" value="123">
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::QUANTITY?>">
        <input class="input-text" type="text" value="123">
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::TITLE?>">
        <textarea class="input-text" hidden><?=$product->name?></textarea>
        <span class="text"><?=$product->name?></span>
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::DESCRIPTION?>">
        <textarea class="input-text" hidden><?=$specifications->description?></textarea>
        <span class="text"><?=$specifications->description?></span>
    </div>
    <?php /** @var Buletpoint $buletpoint */?>
    <?php foreach ($product->buletpoints as $buletpoint): ?>
        <div class="table-cell editable text" data-id="<?=ProductTableStructure::BULLETPOINT?>">
            <textarea class="input-text" data-id="<?=$buletpoint->id?>" hidden><?=$buletpoint->buletpoint?></textarea>
            <span class="text"><?=$buletpoint->buletpoint?></span>
        </div>
    <?php endforeach; ?>
    <?php 
        $lastBP = ProductTableStructure::BULLETPOINT_COUNT - count($product->buletpoints);
        if($lastBP > 0):
            for ($i = ProductTableStructure::BULLETPOINT_COUNT - $lastBP + 1; $i <= ProductTableStructure::BULLETPOINT_COUNT; $i++):
    ?>
                <div class="table-cell editable text" data-id="<?=ProductTableStructure::BULLETPOINT?>">
                    <textarea class="input-text" data-id="<?=(0-$i)?>" hidden></textarea>
                    <span class="text"></span>
                </div>
    <?php
            endfor;
        endif;
    ?>
    <?php /** @var ProductImage $image */?>
    <?php foreach ($product->images as $image): ?>
        <div class="table-cell editable text" data-id="<?=ProductTableStructure::IMAGE?>">
            <textarea class="input-text" data-id="<?=$image->id?>" hidden><?=$image->image?></textarea>
            <span class="text"><?=$image->image?></span>
        </div>
    <?php endforeach; ?>
    <?php
        $lastIM = ProductTableStructure::IMAGE_COUNT - count($product->images);
        if($lastIM > 0):
            for ($i = ProductTableStructure::IMAGE_COUNT - $lastIM + 1; $i <= ProductTableStructure::IMAGE_COUNT; $i++):
    ?>
                <div class="table-cell editable text" data-id="<?=ProductTableStructure::IMAGE?>">
                    <textarea class="input-text" data-id="<?=(0-$i)?>" hidden></textarea>
                    <span class="text"></span>
                </div>
    <?php
            endfor;
        endif;
    ?>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::SWATCH_IMAGE?>">
        <textarea class="input-text" hidden><?=$specifications->swatch_image?></textarea>
        <span class="text"><?=$specifications->swatch_image?></span>
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::BARCODE?>">
        <input class="input-text" type="text" value="<?=$specifications->barcode?>">
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::BARCODE_TYPE?>">
        <?php
            echo $this->render('@layouts/common/simple_select', [
                'title' => $specifications->barcodeType->type,
                'value' => $specifications->barcode_type_id,
            ])
        ?>
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::BROWSE_NODE?>">
        <input class="input-text" type="text" value="<?=$specifications->browseNode->node?>">
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::AMAZON_PRODUCT_TYPE?>">
        <?php
            echo $this->render('@layouts/common/simple_select', [
                'title' => $specifications->amazonProductType->id,
                'value' => $specifications->amazon_product_type_id,
            ])
        ?>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::VARIATION_THEME?>">
        <?php
            echo $this->render('@layouts/common/simple_select', [
                'title' => $specifications->variationTheme->title,
                'value' => $specifications->variation_theme_id,
            ])
        ?>
    </div>
