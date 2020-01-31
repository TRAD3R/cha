<?php
/** 
 * @var $this \yii\web\View
 * @var $devices Device[]
 * @var $params array
 * @var $offset int
 * @var $totalCount int
 */

use App\Models\Device;
use App\Params;

?>
<?=$this->render("@layouts/common/preloader");?>

<?php
$from = $offset + 1;
$to = $params[Params::PER_PAGE] * $params[Params::PAGE];
$to = $to < $totalCount ? $to : $totalCount
?>

<div class="shown-on-page">
    <?=Yii::t('front', 'SHOWN_FROM_TO_OF', ['from' => $from, 'to' => $to, 'total' => $totalCount])?>
</div>

<?=$this->render('includes/table', compact('devices', 'totalCount', 'params', 'offset'));?>



