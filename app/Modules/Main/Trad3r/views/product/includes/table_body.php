<?php 
/** 
 * @var $this View
 * @var Product[] $products 
 * @var Product $product  
 * @var int $offset  
 */

use App\Models\Product;
use App\Models\ProductSpecification;
use yii\web\View;

?>
<div class="table-body-wrapper">
    <div id="empty-row-parent" class="table-row hidden-el" data-id="0">
        <?=$this->render('table_row_parent', [
            'product' => new Product(),
        ])?>
    </div>
    <div id="empty-row-child" class="table-row hidden-el" data-id="0">
        <?=$this->render('table_row_child', [
            'product' => new Product(),
        ])?>
    </div>
  <div class="table-body">
    <?php foreach ($products as $key => $product):?>
        <div class="table-row" data-id="<?=$product->id?>">
            <?= $this->render('table_row_parent', [
                    'product' => $product
            ]); ?>
        </div>
        <?php
            if ($children = $product->children):
                foreach ($children as $child): 
        ?>
                  <div class="table-row" data-id="<?=$child->id?>">
                        <?=$this->render('table_row_child', [
                                'product' => $child
                        ]);?>
                  </div>
        <?php
                endforeach;
            endif;
        ?>
    <?php endforeach; ?>
  </div>
</div>



