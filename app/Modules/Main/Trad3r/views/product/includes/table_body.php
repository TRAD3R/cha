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
            <?php 
                $template = $product->parent_id ? 'table_row_child' : 'table_row_parent';
                echo $this->render($template, compact('product'))
            ?>
          </div>
    <?php endforeach; ?>
  </div>
</div>



