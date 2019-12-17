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
  <ul>
    <li><a class="pagination-arrow-l <?= $paginator->isEnabledPrev() ? '' : 'disabled'; ?>" href="<?= $create_url($paginator->getPrevPage()); ?>">
        <svg width="9" height="15" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1.08395 7.23271L7.10373 1.21312C7.48666 0.830002 8.10752 0.830002 8.49026 1.21312C8.87304 1.59589 8.87304 2.21672 8.49026 2.59946L3.16369 7.92588L8.49011 13.2521C8.87288 13.635 8.87288 14.2558 8.49011 14.6386C8.10733 15.0215 7.48651 15.0215 7.10357 14.6386L1.0838 8.6189C0.892409 8.42742 0.796823 8.17673 0.796823 7.92591C0.796823 7.67497 0.892595 7.4241 1.08395 7.23271Z" fill="inherit"/>
        </svg>
      </a></li>
    <?php foreach ($paginator->getPages() as $page): ?>
      <?php if ($page === null): ?>
        <li><a class="pagination-null" href="javascript:;"><span>...</span></a></li>
        <?php continue; ?>
      <?php endif; ?>
      <li><a class="pagination-item <?= $paginator->isActive($page) ? 'active' : ''; ?>" href="<?= $create_url($page); ?>"><?= $page; ?></a></li>
    <?php endforeach; ?>
    <li><a class="pagination-arrow-r <?= $paginator->isEnabledNext() ? '' : 'disabled'; ?>" href="<?= $create_url($paginator->getNextPage()); ?>">
        <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.69339 7.23271L1.67361 1.21312C1.29068 0.830002 0.669826 0.830002 0.287082 1.21312C-0.0956939 1.59589 -0.0956938 2.21672 0.287082 2.59946L5.61366 7.92588L0.287238 13.2521C-0.095538 13.635 -0.095538 14.2558 0.287238 14.6386C0.670013 15.0215 1.29084 15.0215 1.67377 14.6386L7.69355 8.6189C7.88493 8.42742 7.98052 8.17673 7.98052 7.92591C7.98052 7.67497 7.88475 7.4241 7.69339 7.23271Z" fill="inherit"/>
        </svg>
      </a></li>
  </ul>
</div>
