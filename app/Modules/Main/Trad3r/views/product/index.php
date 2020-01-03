<?php
/** 
 * @var $this \yii\web\View
 * @var $devices Device[]
 * @var $params array
 * @var $offset int
 */

use App\Models\Device;
$products = [];
?>

<?php echo $this->render('includes/table', compact('products', 'totalCount', 'params', 'offset')); ?>





