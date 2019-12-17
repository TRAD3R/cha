<?php
/** 
 * @var $this \yii\web\View
 * @var $devices Device[]
 * @var $params array
 * @var $offset int
 */

use App\Models\Device;

?>

<div class="container-fluid">
  <?php echo $this->render('includes/device/table', compact('devices', 'totalCount', 'params', 'offset')); ?>
</div>



