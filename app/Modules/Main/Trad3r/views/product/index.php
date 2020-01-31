<?php
/** 
 * @var $this \yii\web\View
 * @var Product[] $products
 * @var $params array
 * @var $offset int
 * @var $totalCount int
 */

use App\Models\Product;
use App\Params;

?>
<?php echo $this->render("@layouts/common/preloader"); ?>

<?php
$from = $offset + 1;
$to = $params[Params::PER_PAGE] * $params[Params::PAGE];
$to = $to < $totalCount ? $to : $totalCount
?>

<div class="shown-on-page">
    <?=Yii::t('front', 'SHOWN_FROM_TO_OF', ['from' => $from, 'to' => $to, 'total' => $totalCount])?>
</div>

<?php echo $this->render('includes/table', compact('products', 'totalCount', 'params', 'offset')); ?>





