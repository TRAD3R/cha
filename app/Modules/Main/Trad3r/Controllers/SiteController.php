<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;
use App\Forms\LoginForm;

class SiteController extends Main
{
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
   
}