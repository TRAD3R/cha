<?php

$ths = [
    '',
    'DATE_CREATED',
    'DEVICE_TYPE',
    'DEVICE_BRAND',
    'DEVICE_MODEL',
    'LENGTH',
    'WIDTH',
    'DEPTH',
    'SCREEN_SIZE',
    'CARD_MEMORY',
    '35_JACK',
    'BLUETOOTH',
    'USB_TYPE',
    'USB_STANDARD',
    'WIRELESS_CHARGE',
    'FAST_CHARGE',
    'REMOVABLE_BATTERY',
    'PRICE',
    'IMAGE',
]
?>

<thead>
    <tr>
        <?php foreach ($ths as $th):?>
            <th><?=Yii::t('front', $th);?></th>
        <?php endforeach; ?>
    </tr>
</thead>
