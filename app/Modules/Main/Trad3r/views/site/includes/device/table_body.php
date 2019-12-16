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
      /** @var DeviceSpecification $specifications */
      $specifications = $device->specifications;
      $sequenceNumber = ++$key + $offset;
      ?>
      <div class="table-row">
        <div class="btn-box-wrapper"></div>
        <?=$this->render('table_row', compact('device', 'specifications', 'sequenceNumber'))?>
      </div>
    <?php endforeach; ?>
  </div>
</div>



