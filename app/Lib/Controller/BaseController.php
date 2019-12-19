<?php


namespace App\Controller;


use App\App;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->getRequest()->isAjax()) {
            $this->getResponse()->setJsonFormat();
        }

        return true;
    }

    public function getRequest()
    {
        return App::i()->getRequest();
    }

    /**
     * @return \App\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getResponse()
    {
        return App::i()->getResponse();
    }
}