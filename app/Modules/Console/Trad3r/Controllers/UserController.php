<?php


namespace Console\Trad3r\Controllers;


use App\Models\User;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{
    /**
     * Добавление нового админа для доступа. Команда: user/add {EMAIL} {PASSWORD}
     * @param string $email
     * @param string $password
     */
    public function actionAdd(string $email, string $password)
    {
        $user = new User();
        $user->email = $email;
        $user->setPasswordHash($password);
        
        if($user->save()) {
            echo Yii::t('front', 'ADDED_NEW_USER');
        }else{
            $this->printErrors($user->getErrors());
        }
        echo PHP_EOL;
    }
    private function printErrors($errors)
    {
        foreach ($errors as $error) {
            echo $error[0];
        }
    }
}