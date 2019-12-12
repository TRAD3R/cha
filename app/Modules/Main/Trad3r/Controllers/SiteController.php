<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;
use App\Forms\LoginForm;
use App\Models\Device;

class SiteController extends Main
{
    public function actionIndex()
    {
        $devices = Device::find()
            ->limit(100)
            ->orderBy('id')
            ->all()
            ;
        return $this->render('index', [
            'devices' => $devices,
        ]);
    }
   
}