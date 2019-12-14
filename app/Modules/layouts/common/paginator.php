<?php
/**
 * @var \yii\web\View $this
 *
 * @var int           $total_count сколько всгео страниц
 * @var int           $page        на какой странице находимся
 * @var int           $per_page    кол-во выводимой информаци на страницу
 * @var int           $page_range  кол-во элементов страниц, которые нужны на странице
 */

use App\Helpers\Url;
use App\Helpers\Paginator;

if ($total_count == 0) {
    return false;
}

$paginator = new Paginator($page, $per_page, $total_count);

$create_url = function ($page) {
    return Url::toRoute(['', 'page' => $page] + $_GET);
};

if (count($paginator->getPages()) < 2) {
    return false;
}
?>
<div class="pagination offers-pagination">
    <a class="pagination__arrow-l <?= $paginator->isEnabledPrev() ? '' : 'disabled'; ?>" href="<?= $create_url($paginator->getPrevPage()); ?>"></a>
    <?php foreach ($paginator->getPages() as $page): ?>
    <?php if ($page === null): ?>
        <a class="pagination-null" href="javascript:;"><span>...</span></a>
        <?php continue; ?>
    <?php endif; ?>
    <a class="pagination__item <?= $paginator->isActive($page) ? 'is-active' : ''; ?>" href="<?= $create_url($page); ?>"><?= $page; ?></a>
    <?php endforeach; ?>
    <a class="pagination__arrow-r <?= $paginator->isEnabledNext() ? '' : 'disabled'; ?>" href="<?= $create_url($paginator->getNextPage()); ?>"></a>
</div>
