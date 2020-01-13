<?php
/**
 * @var $product Product
 */

use App\Helpers\PriceHelper;
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
            $dateCreated = new DateTime($product->date_created);
            echo $dateCreated->format('d.m.Y');
        } catch (Exception $e) {
            $e->getMessage();
        }
        ?>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::NODE?>">
        <span class="text"><?=Yii::t('front', 'CHILD');?></span>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::PARENT_ID?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::PARENT_ID,
            'placeholder' => Yii::t('front', 'PARENT'),
            'isMultiple' => false,
            'selected'  => $product->parent_id ? [$product->parent_id => $product->parent_id] : [],
        ]); ?>
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
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::BRAND?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::BRAND,
            'placeholder' => Yii::t('front', 'BRAND'),
            'isMultiple' => false,
            'selected'  => $specifications->product_brand_id ? [$specifications->product_brand_id => $specifications->productBrand->name] : [],
        ]); ?>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::MANUFACTURER?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::MANUFACTURER,
            'placeholder' => Yii::t('front', 'MANUFACTURER'),
            'isMultiple' => false,
            'selected'  => $specifications->manufacturer_id ? [$specifications->manufacturer_id => $specifications->manufacturer->name] : [],
        ]); ?>
    </div>
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::LENGTH?>">
        <input class="input-text" type="text" value="<?=$specifications->length?>">
    </div>
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::WIDTH?>">
        <input class="input-text" type="text" value="<?=$specifications->width?>">
    </div>
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::DEPTH?>">
        <input class="input-text" type="text" value="<?=$specifications->depth?>">
    </div>
    <div class="table-cell editable text"  data-id="<?=ProductTableStructure::SIZE?>">
        <input class="input-text" type="text" value="<?=$specifications->size?>">
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::UNIT_MEASURE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::UNIT_MEASURE,
            'placeholder' => Yii::t('front', 'UNIT_MEASURE'),
            'isMultiple' => false,
            'selected'  => $specifications->measure_unit_id ? [$specifications->measure_unit_id => $specifications->measureUnit->type] : [],
        ]); ?>
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::PRICE?>">
        <input class="input-text" type="text" value="<?=PriceHelper::toFloat($specifications->price)?>">
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::QUANTITY?>">
        <input class="input-text" type="text" value="<?=$specifications->quantity?>">
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::TITLE?>">
        <textarea class="input-text" hidden><?=$product->name?></textarea>
        <span class="text"><?=$product->name?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::DESCRIPTION?>">
        <textarea class="input-text" hidden><?=$specifications->description?></textarea>
        <span class="text"><?=$specifications->description?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_1?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_1?>" hidden><?=$specifications->bulletpoint_1?></textarea>
        <span class="text"><?=$specifications->bulletpoint_1?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_2?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_2?>" hidden><?=$specifications->bulletpoint_2?></textarea>
        <span class="text"><?=$specifications->bulletpoint_2?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_3?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_3?>" hidden><?=$specifications->bulletpoint_3?></textarea>
        <span class="text"><?=$specifications->bulletpoint_3?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_4?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_4?>" hidden><?=$specifications->bulletpoint_4?></textarea>
        <span class="text"><?=$specifications->bulletpoint_4?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_5?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_5?>" hidden><?=$specifications->bulletpoint_5?></textarea>
        <span class="text"><?=$specifications->bulletpoint_5?></span>
    </div>
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
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::SWATCH_IMAGE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::SWATCH_IMAGE,
            'placeholder' => Yii::t('front', 'SWATCH_IMAGE'),
            'isMultiple' => false,
            'selected'  => $specifications->swatch_id ? [$specifications->swatch_id => $specifications->swatch->title] : [],
        ]); ?>
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::BARCODE?>">
        <input class="input-text" type="text" value="<?=$specifications->barcode?>">
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::BARCODE_TYPE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::BARCODE_TYPE,
            'placeholder' => Yii::t('front', 'BARCODE_TYPE'),
            'isMultiple' => false,
            'selected'  => $specifications->barcode_type_id ? [$specifications->barcode_type_id => $specifications->barcodeType->type] : [],
        ]); ?>
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell">
    </div>
