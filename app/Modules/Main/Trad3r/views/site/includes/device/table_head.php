<?php

use App\Lib\Tables\TableStructure;

$ths = TableStructure::getDeviceTitles();
?>

<div class="table-head">
  <div class="table-row">
    <?php foreach ($ths as $key => $group):?>
<!--      <div class="table-group gr---><?//=$key ?><!--">-->
        <?php foreach ($group as $th):?>
          <div class="group-cell gr-<?=$key ?> table-cell"><?=Yii::t('front', $th);?></div>
        <?php endforeach; ?>
<!--      </div>-->
    <?php endforeach; ?>
  </div>
</div>
