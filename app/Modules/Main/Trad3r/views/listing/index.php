<?php
/**
 * @var \yii\web\View   $this
 * @var Product[]       $products
 * @var Product[]       $products
 * @var array           $gadgets
 * @var array           $params
 * @var int             $totalCount
 * @var int             $offset
 */

use App\Helpers\ListingHelper;
use App\Helpers\TextHelper;
use App\Html;
use App\Models\Product;
use App\Params;

?>
<?php //echo $this->render("@layouts/common/preloader"); ?>
<?php //echo $this->render('includes/table', compact('products', 'totalCount', 'params', 'offset')); ?>

<?php if($params[Params::LISTING_TYPE] == ListingHelper::DEVICES): ?>
    <div class="btn-operations is-active">
        <div class="btn-operations-edit">
            <?php echo $this->render('partitials/filters', compact('products', 'params'));?>
        </div>
    </div>
<?php 
    endif;

    echo $this->render('includes/table', compact('params', 'totalCount', 'gadgets', 'offset'))
?>

