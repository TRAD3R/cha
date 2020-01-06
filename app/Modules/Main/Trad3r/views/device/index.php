<?php
/** 
 * @var $this \yii\web\View
 * @var $devices Device[]
 * @var $params array
 * @var $offset int
 */

use App\Models\Device;

?>
<?php echo $this->render('includes/table', compact('devices', 'totalCount', 'params', 'offset', 'brands', 'model')); ?>



