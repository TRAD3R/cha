<?php
/**
 * @var $this \yii\web\View
 * @var $model LoginForm
 */

use App\Forms\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('front', 'AUTHENTIFICATION');
?>
<?php
    $form = ActiveForm::begin();
?>
    <?=$form->field($model, 'email')->input('email')?>
    <?=$form->field($model, 'password')->passwordInput()?>
    <?=$form->field($model, 'remember_me')->checkbox()?>

    <?=Html::submitButton('Войти')?>
<?php ActiveForm::end()?>
