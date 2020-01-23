<?php
/**
 * @var $product Product
 */

use App\App;
use App\Helpers\PriceHelper;
use App\Helpers\TextHelper;
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
        <input class="input-text" type="number" value="<?=PriceHelper::toFloat($specifications->price)?>">
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::QUANTITY?>">
        <input class="input-text" type="text" value="<?=$specifications->quantity?>">
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::TITLE?>">
        <textarea class="input-text" hidden><?=$product->name?></textarea>
        <pre class="text"><?=$product->name?></pre>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::DESCRIPTION?>">
        <textarea class="input-text" hidden><?=$specifications->description?></textarea>
        <pre class="text"><?=$specifications->description?></pre>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::KEYWORDS?>">
        <textarea class="input-text" hidden><?=$specifications->keywords?></textarea>
        <pre class="text"><?=$specifications->keywords?></pre>
    </div>
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::VAR_TITLE?>">
        <input class="input-text" type="text" value="<?=$specifications->var_title?>">
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_1?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_1?>" hidden><?=$specifications->bulletpoint_1?></textarea>
        <pre class="text"><?=$specifications->bulletpoint_1?></pre>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_2?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_2?>" hidden><?=$specifications->bulletpoint_2?></textarea>
        <pre class="text"><?=$specifications->bulletpoint_2?></pre>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_3?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_3?>" hidden><?=$specifications->bulletpoint_3?></textarea>
        <pre class="text"><?=$specifications->bulletpoint_3?></pre>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_4?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_4?>" hidden><?=$specifications->bulletpoint_4?></textarea>
        <pre class="text"><?=$specifications->bulletpoint_4?></pre>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::BULLETPOINT_5?>">
        <textarea class="input-text" data-id="<?=$specifications->bulletpoint_5?>" hidden><?=$specifications->bulletpoint_5?></textarea>
        <pre class="text"><?=$specifications->bulletpoint_5?></pre>
    </div>
    <?php for ($i = 1; $i <= ProductTableStructure::IMAGE_COUNT; $i++):
        if($specifications):
            $sku = $specifications->sku;
            $src = TextHelper::createUsingFilename($sku, $i);
    ?>
            <div class="table-cell image">
                <img src="<?=App::i()->getFile()->mdUrl("/accessories/using/" . $src)?>" alt="">
            </div>
        <?php endif;?>
    <?php endfor;?>
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
