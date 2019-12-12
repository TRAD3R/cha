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
    $form = ActiveForm::begin([
        'id' => 'form-login',
    ]);
?>
    <?=$form->field($model, 'email', ['template' => '{input}{label}{error}{hint}'])->input('email')?>
    <?=$form->field($model, 'password', ['template' => '{input}{label}{error}{hint}'])->passwordInput()?>
    <?=$form->field($model, 'remember_me', ['template' => '{input}{label}{error}{hint}'])->checkbox()?>

    <?=Html::submitButton('Войти', ['name' => 'login'])?>
<?php ActiveForm::end()?>
