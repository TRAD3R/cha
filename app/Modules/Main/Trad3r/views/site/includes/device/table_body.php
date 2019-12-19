<?php 
/** 
 * @var $this View
 * @var $devices Device[]
 * @var $device Device 
 * @var $offset int 
 */

use App\Models\Device;
use App\Models\DeviceSpecification;
use yii\web\View;

?>
<div class="table-body-wrapper">
  <div class="table-body">
    <?php foreach ($devices as $key => $device):?>
          <?php
              $sequenceNumber = ++$key + $offset;
          ?>
    
          <div class="table-row" data-id="<?=$device->id?>">
            <?=$this->render('table_row', compact('device', 'sequenceNumber'))?>
          </div>
    <?php endforeach; ?>
  </div>
</div>



