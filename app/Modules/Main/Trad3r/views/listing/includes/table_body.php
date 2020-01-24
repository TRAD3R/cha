<?php
/**
 * @var View        $this
 * @var Device[]|Product[]   $products
 * @var int         $offset
 */

use App\Models\Device;
use App\Models\Product;
use yii\web\View;

?>
<div class="table-body-wrapper">
  <div class="table-body">
    <?php foreach ($products as $key => $product):?>
          <div class="table-row" data-id="<?=$product->id?>">
              <?=$this->render('table_row', [
                      'key' => ++$key,
                  'product' => $product,
              ])?>
          </div>
    <?php endforeach; ?>
  </div>
</div>



