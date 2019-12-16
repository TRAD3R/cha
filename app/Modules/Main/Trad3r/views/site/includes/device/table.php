<?php

use App\Html;
use App\Models\Device;
use App\Params;

/**
 * @var $devices Device[]
 * @var $totalCount int
 * @var $params array
 * @var $offset int
 */
 ?>
<table>
        <?php echo $this->render('table_head'); ?>
        
        <?php echo $this->render('table_body', compact('devices', 'offset')); ?>
</table>

<?=Html::renderPaginator([
    'page' => 1,
    'per_page' => $params[Params::PER_PAGE],
    'total_count' => $totalCount,
])?>