<?php
/**
 * @var $device Device
 * @var $specifications DeviceSpecification
 * @var $sequenceNumber int
 */

use App\Models\Device;
use App\Models\DeviceSpecification; ?>

<td><?=$sequenceNumber?></td>
<td>
    <?php
    $dateCreated = new DateTime($specifications->date_created);
    echo $dateCreated->format('d.m.Y');
    ?>
</td>
<td>
    <?=$specifications->type->type;?>
</td>
<td>
    <?=$device->brand->name?>
</td>
<td>
    <?=$device->title?>
</td>
<td>
    <?=$specifications->length;?>
</td>
<td>
    <?=$specifications->width;?>
</td>
<td>
    <?=$specifications->depth;?>
</td>
<td>
    <?=$specifications->screensize;?>
</td>
<td>
    <?php
    $cardMemory = $specifications->cardMemory;
    echo $cardMemory ? $cardMemory->size : "";
    ?>
</td>
<td>
    <?=$specifications->jack_35;?>
</td>
<td>
    <?=$specifications->bluetooth;?>
</td>
<td>
    <?php
    $usbType = $specifications->usbType;
    echo $usbType ? $usbType->type : "";
    ?>
</td>
<td>
    <?php
    $usbStandard = $specifications->usbStandard;
    echo $usbStandard ? $usbStandard->standard : "";
    ?>
</td>
<td>
    <?=$specifications->wireless_charge;?>
</td>
<td>
    <?=$specifications->fast_charge;?>
</td>
<td>
    <?=$specifications->removable_battery;?>
</td>
<td>
    <?=$specifications->price;?>
</td>
<td>
    <?=$specifications->image;?>
</td>
