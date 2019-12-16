<?php

use App\Lib\Tables\TableStructure;

$ths = TableStructure::getDeviceTitles();
?>

<thead>
    <tr>
        <?php foreach ($ths as $th):?>
            <th><?=Yii::t('front', $th);?></th>
        <?php endforeach; ?>
    </tr>
</thead>
