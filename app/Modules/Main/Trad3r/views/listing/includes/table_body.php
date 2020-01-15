<?php
/**
 * @var View        $this
 * @var Product[]   $products
 * @var int         $offset
 */

use App\Models\Product;
use yii\web\View;

?>
<div class="table-body-wrapper">
  <div class="table-body">
    <?php foreach ($products as $key => $product):?>
          <div class="table-row">
              <?=$this->render('table_row', compact('product'))?>
          </div>
    <?php endforeach; ?>
  </div>
</div>



