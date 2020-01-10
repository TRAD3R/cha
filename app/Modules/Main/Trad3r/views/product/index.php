<?php
/** 
 * @var $this \yii\web\View
 * @var Product[] $products
 * @var $params array
 * @var $offset int
 */

use App\Models\Product;

?>

<?php echo $this->render('includes/table', compact('products', 'totalCount', 'params', 'offset')); ?>





