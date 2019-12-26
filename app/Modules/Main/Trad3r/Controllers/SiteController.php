<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;

class SiteController extends Main
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}