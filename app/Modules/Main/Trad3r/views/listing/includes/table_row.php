<?php
/**
 * @var View $this
 * @var Product $product
 */

use App\Models\Product;
use yii\web\View;

?>

    <div class="table-cell checkbox"></div>
    <div class="table-cell">
        <?=$product->id?>
    </div>
    <div class="table-cell">
        <?=$product->name?>
    </div>
