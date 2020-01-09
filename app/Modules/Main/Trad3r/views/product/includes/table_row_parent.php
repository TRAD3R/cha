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
    <div class="table-cell sequence-number">
        <?=$product->id?>
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
        <?php $nodeName = TextHelper::upperFirstChar(Yii::t('front', 'PARENT')); ?> 
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
    <div class="table-cell" data-id="<?=ProductTableStructure::PARENT_ID?>">
        <span class="text"><?php echo $product->parent_id ?: '-' ?></span>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::DEVICE_TYPE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
                'name' => ProductTableStructure::DEVICE_TYPE,
                'placeholder' => Yii::t('front', 'DEVICE_TYPE'),
                'isMultiple' => true,
                'selected'  => $specifications->deviceTypes,
        ]); ?>
    </div>
    <div class="table-cell editable select"  data-id="<?=ProductTableStructure::TYPE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::TYPE,
            'placeholder' => Yii::t('front', 'TYPE'),
            'isMultiple' => false,
            'selected'  => (new Product())->getProductType($specifications->type_id ?: 0),
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
    <div class="table-cell editable text" data-id="<?=ProductTableStructure::TITLE?>">
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
    <div class="table-cell text">
        <span class="text"><?=$specifications->browseNode->node?></span>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::BROWSE_NODE?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::BROWSE_NODE,
            'placeholder' => Yii::t('front', 'AMAZON_PRODUCT_TYPE'),
            'isMultiple' => false,
            'selected'  => $specifications->browse_node_id ? [$specifications->browseNode->id => $specifications->browseNode->product_type] : [],
        ]); ?>
    </div>
    <div class="table-cell editable select" data-id="<?=ProductTableStructure::VARIATION_THEME?>">
        <?php echo $this->render('@layouts/common/chosen-select', [
            'name' => ProductTableStructure::VARIATION_THEME,
            'placeholder' => Yii::t('front', 'VARIATION_THEME'),
            'isMultiple' => false,
            'selected'  => $specifications->variation_theme_id ? [$specifications->variation_theme_id => $specifications->variationTheme->title] : [],
        ]); ?>
    </div>