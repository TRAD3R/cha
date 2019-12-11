<?php


namespace Main\Trad3r\Controllers;


use App\App;
use App\Controller\Main;
use App\Forms\LoginForm;
use Yii;

class AuthController extends Main
{
    public function actionLogin()
    {
        $form = new LoginForm();
        
        if($this->getRequest()->isPost()) {
            if($form->load($this->getRequest()->post()) && $form->login()) {
                return $this->redirect('/');
            }
        }
        
        return $this->render('login', [
            'model' => $form,
        ]);
    }
}