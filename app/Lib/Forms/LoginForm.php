<?php


namespace App\Forms;


use App\App;
use App\Model;
use App\Models\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

/**
 * Class LoginForm
 * @property User $_entity
 * @package App\Forms
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $remember_me;
    public $recaptcha;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['remember_me', 'boolean'],
//            ['recaptcha', 'validateRecaptcha'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'   => Yii::t('front', 'EMAIL'),
            'password'   => Yii::t('front', 'PASSWORD'),
            'remember_me' => Yii::t('front', 'REMEMBER_ME')
        ];
    }
    
    public function validatePassword()
    {
        if(!$this->hasErrors()) {
            $user = $this->getUser();
            if(!$user || !$user->validatePassword($this->password)) {
                $this->addError('remember_me', Yii::t('exception', 'WRONG_EMAIL_OR_PASSWORD'));
            }
        }
    }

    /**
     * @throws InvalidConfigException
     */
    public function validateRecaptcha()
    {
        if (!$this->hasErrors()) {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl('https://www.google.com/recaptcha/api/siteverify')
                ->setData([
                    'secret' => App::i()->getApp()->params['captcha']['secretKey_3'],
                    'response' => $this->recaptcha
                ])
                ->send();

            if ($response->isOk) {
                if (!$response->data['success'] || $response->data['score'] < 0.5) {
                    $this->addError('remember_me', 'Произошла ошибка. Попробуйте еще раз');
                }
            }
        }
    }
    
    public function login()
    {
        if($this->validate()) {
            if($this->getUser()) {
                return Yii::$app->getUser()->login($this->getUser(), $this->remember_me ? 60 * 60 * 24 * 7 : 0);
            }
        }
        
        return false;
    }

    private function getUser()
    {
        if($this->_entity === false) {
            $this->_entity = User::findOne([
                'email' => $this->email
            ]);
        }
        
        return $this->_entity;
    }


}