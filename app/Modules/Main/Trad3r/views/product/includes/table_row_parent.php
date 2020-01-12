<?php
/**
 * @var Product $product
 */

use App\Models\Product;
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
        }
        ?>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::NODE?>">
        <span class="text"><?=Yii::t('front', 'PARENT');?></span>
    </div>
    <div class="table-cell" data-id="<?=ProductTableStructure::PARENT_ID?>">
        <span class="text"><?php echo $product->parent_id ?: '-' ?></span>
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
    <div class="table-cell editable textarea" data-id="<?=ProductTableStructure::TITLE?>">
        <textarea class="input-text" hidden><?=$product->name?></textarea>
        <span class="text"><?=$product->name?></span>
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
    <div class="table-cell">
    </div>
    <div class="table-cell">
    </div>
    <div class="table-cell">
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
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::VARIATION_THEME,
            'placeholder' => Yii::t('front', 'VARIATION_THEME'),
            'isMultiple' => false,
            'selected'  => $specifications->variation_theme_id ? [$specifications->variation_theme_id => $specifications->variationTheme->title] : [],
        ]); ?>
    </div>