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
            $dateCreated = new DateTime($specifications->date_created);
            echo $dateCreated->format('d.m.Y');
        } catch (Exception $e) {
            $e->getMessage();
        }
        ?>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::NODE?>">
        <span class="text"><?=Yii::t('front', 'INDIVIDUAL');?></span>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::PARENT_ID?>">
        <span class="text<?php echo $product->parent_id ?: ' no-parent' ?>"></span>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::DEVICE_TYPE?>">
        <?php
        $selected = [];
        if($deviceTypes = $specifications->deviceTypes) {
            foreach ($deviceTypes as $deviceType) {
                $selected[$deviceType->id] = $deviceType->type;
            }
        }
        ?>
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::DEVICE_TYPE,
            'placeholder' => Yii::t('front', 'DEVICE_TYPE'),
            'isMultiple' => true,
            'selected'  => $selected,
        ]); ?>
    </div>
    <div class="table-cell editable select"  data-id="<?=ProductTableStructure::TYPE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::TYPE,
            'placeholder' => Yii::t('front', 'TYPE'),
            'isMultiple' => false,
            'selected'  => $specifications->type_id ? [$specifications->type_id => $specifications->type->type] : [],
        ]); ?>
    </div>
    <div class="table-cell editable select"  data-id="<?=ProductTableStructure::MERCHANT?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::MERCHANT,
            'placeholder' => Yii::t('front', 'MERCHANT'),
            'isMultiple' => false,
            'selected'  => $specifications->merchant_id ? [$specifications->merchant_id => $specifications->merchant->name] : [],
        ]); ?>
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
        <textarea class="input-text" hidden><?=$product->title?></textarea>
        <span class="text"><?=$product->title?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::DESCRIPTION?>">
        <textarea class="input-text" hidden><?=$specifications->description?></textarea>
        <span class="text"><?=$specifications->description?></span>
    </div>
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::KEYWORDS?>">
        <textarea class="input-text" hidden><?=$specifications->keywords?></textarea>
        <span class="text"><?=$specifications->keywords?></span>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::VAR_TITLE?>"></div>
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
    <?php for ($i = 1; $i <= ProductTableStructure::IMAGE_COUNT; $i++):
        if($specifications):
            $sku = $specifications->sku;
            $src = TextHelper::createUsingFilename($sku, $i);
            $relativeFilepath = "/images/accessories/using/" . $src;
            $src = is_file(Yii::getAlias("@Web") . $relativeFilepath) ? $relativeFilepath : App::i()->getFile()->getNoImage();
            ?>
            <div class="table-cell image">
                <img src="<?=App::i()->getFile()->mdUrl($src)?>" alt="">
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
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::BROWSE_NODE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::BROWSE_NODE,
            'placeholder' => Yii::t('front', 'AMAZON_PRODUCT_TYPE'),
            'isMultiple' => false,
            'selected'  => $specifications->browse_node_id ? [$specifications->browseNode->id => $specifications->browseNode->title] : [],
        ]); ?>
    </div>
    <div class="table-cell">
        <span class="text"><?=$specifications->browseNode->node?></span>
    </div>
    <div class="table-cell">
        <span class="text"><?=$specifications->browseNode->product_type?></span>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::VARIATION_THEME?>">
    </div>
