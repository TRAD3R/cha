<?php
/** 
 * @var $this \yii\web\View
 * @var $devices Device[]
 */

use App\Models\Device;

?>
<div id="tabs">Привет</div>

<table>
    <thead>
        <th></th>
        <th><?=Yii::t('front', 'DATE_CREATED');?></th>
        <th><?=Yii::t('front', 'DEVICE_TYPE');?></th>
        <th><?=Yii::t('front', 'DEVICE_BRAND');?></th>
        <th><?=Yii::t('front', 'DEVICE_MODEL');?></th>
        <th><?=Yii::t('front', 'LENGTH');?></th>
        <th><?=Yii::t('front', 'WIDTH');?></th>
        <th><?=Yii::t('front', 'DEPTH');?></th>
        <th><?=Yii::t('front', 'SCREEN_SIZE');?></th>
        <th><?=Yii::t('front', 'CARD_MEMORY');?></th>
        <th><?=Yii::t('front', '35_JACK');?></th>
        <th><?=Yii::t('front', 'BLUETOOTH');?></th>
        <th><?=Yii::t('front', 'USB_TYPE');?></th>
        <th><?=Yii::t('front', 'USB_TYPE');?></th>
        <th><?=Yii::t('front', 'WIRELESS_CHARGE');?></th>
        <th><?=Yii::t('front', 'FAST_CHARGE');?></th>
        <th><?=Yii::t('front', 'REMOVABLE_BATTERY');?></th>
        <th><?=Yii::t('front', 'PRICE');?></th>
        <th><?=Yii::t('front', 'IMAGE');?></th>
    </thead>
    <tbody>
    <?php /** @var $device Device */?>
    <?php foreach ($devices as $key => $device):?>
        <tr>
            <td><?=$key + 1?></td>
            <td>
                <?=$device->specifications->date_created;?>
            </td>
            <td>
                <?=$device->specifications->type->type;?>
            </td>
            <td>
                <?=$device->brand->name?>
            </td>
            <td>
                <?=$device->title?>
            </td>
            <td>
                <?=$device->specifications->length;?>
            </td>
            <td>
                <?=$device->specifications->width;?>
            </td>
            <td>
                <?=$device->specifications->depth;?>
            </td>
            <td>
                <?=$device->specifications->screensize;?>
            </td>
            <td>
                <?php
                    $cardMemory = $device->specifications->cardMemory;
                    echo $cardMemory ? $cardMemory->size : "";
                ?>
            </td>
            <td>
                <?=$device->specifications->jack_35;?>
            </td>
            <td>
                <?=$device->specifications->bluetooth;?>
            </td>
            <td>
                <?php
                    $usbType = $device->specifications->usbType;
                    echo $usbType ? $usbType->type : "";
                ?>
            </td>
            <td>
                <?php
                    $usbStandard = $device->specifications->usbStandard;
                    echo $usbStandard ? $usbStandard->standard : "";
                ?>
            </td>
            <td>
                <?=$device->specifications->wireless_charge;?>
            </td>
            <td>
                <?=$device->specifications->fast_charge;?>
            </td>
            <td>
                <?=$device->specifications->removable_battery;?>
            </td>
            <td>
                <?=$device->specifications->price;?>
            </td>
            <td>
                <?=$device->specifications->image;?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

