<?php


namespace App\Controller;


use App\App;
use App\Assets\AssetHelper;
use yii\filters\AccessControl;

abstract class Main extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if(!$this->getRequest()->isAjax()) {
            AssetHelper::init($this->view);
        }
        
        return true;
    }
}