<?php


use App\Params;
use App\Tables\ProductTableStructure;
use yii\web\View;

/**
 * @var View $this
 * @var array $sortedColumnsAsc
 * @var array $sortedColumnsDesc
 */
$ths = ProductTableStructure::getTitles();
$sortedColumns = ProductTableStructure::getSortedColumns();
?>

<div class="table-head">
  <div class="table-row">
    <?php foreach ($ths as $groupKey => $group){
        foreach ($group as $key => $th) {
            if(in_array($key, [ProductTableStructure::IMAGE])) {
                $count = ProductTableStructure::IMAGE_COUNT;
                
                for ($i = 0; $i < $count; $i++){
                    echo $this->render('headers', compact('groupKey', 'sortedColumnsAsc', 'sortedColumnsDesc', 'key', 'th', 'sortedColumns'));
                }
            }else {
                echo $this->render('headers', compact('groupKey', 'sortedColumnsAsc', 'sortedColumnsDesc', 'key', 'th', 'sortedColumns'));
            }
        }
    }
?>
  </div>
</div>
