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
<div class="login-page">
    <div class="form login-form">
        <?php
        $form = ActiveForm::begin([
          'id' => 'form-login',
        ]);
        ?>
        <?=$form->field($model, 'email', ['template' => '{label}{input}{error}{hint}'])->input('email')?>
        <?=$form->field($model, 'password', ['template' => '{label}{input}{error}{hint}'])->passwordInput()?>
        <?=$form->field($model, 'remember_me', ['template' => '{label}{input}{error}{hint}'])->checkbox()?>

        <?=Html::submitButton('Войти', ['name' => 'login'])?>
        <?php ActiveForm::end()?>
    </div>
</div>

