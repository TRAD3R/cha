<?php
/** @var $this \yii\web\View */
/** @var string $content контент страницы */

?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
  <title><?=$this->title?></title>
  <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?=$content?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
