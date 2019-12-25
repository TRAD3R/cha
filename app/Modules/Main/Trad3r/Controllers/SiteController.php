<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;
use App\Helpers\DeviceHelper;
use App\Models\Device;
use App\Models\DeviceSpecification;
use App\Params;
use App\Request;
use App\Response;
use Yii;

class SiteController extends Main
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}