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
    <div id="empty-row" class="table-row hidden-el" data-id="0">
        <?=$this->render('table_row', [
            'device' => new Device(), 
            'sequenceNumber' => 0
        ])?>
    </div>
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



