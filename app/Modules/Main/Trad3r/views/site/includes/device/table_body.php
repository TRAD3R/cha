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
    <?php foreach ($devices as $key => $device):?>
        <?php
            /** @var DeviceSpecification $specifications */
            $specifications = $device->specifications; 
            $sequenceNumber = ++$key + $offset;
        ?>
        <tr data-id="<?=$device->id;?>">
            <?=$this->render('table_row', compact('device', 'specifications', 'sequenceNumber'))?>
        </tr>
    <?php endforeach; ?>

