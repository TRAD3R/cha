<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;
use App\Forms\LoginForm;
use App\Helpers\DeviceHelper;
use App\Models\Device;
use App\Params;
use App\Request;
use App\Response;
use yii\data\Pagination;

class SiteController extends Main
{
    public function actionIndex()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        
        $params = [
            Params::PAGE        => $request->get(Params::PAGE) ?: 1,
            Params::PER_PAGE    => $request->get(Params::PER_PAGE) ?: DeviceHelper::PER_PAGE,
        ];
        
        $offset = ($params[Params::PAGE] - 1) * $params[Params::PER_PAGE];
        $devices = DeviceHelper::getDevices($params[Params::PER_PAGE], $offset);
        
        $totalCount = Device::find()->count();
        return $this->render('index', [
            'devices' => $devices,
            'totalCount' => $totalCount,
            'params' => $params,
            'offset' => $offset
        ]);
    }
    
    public function actionDeviceUpdate($id)
    {
        /** @var Request $request */
        $request = $this->getRequest();
        
        if(!$request->isAjax() || !$request->isPost()) {
            $this->getResponse()->set404();
        }
        
        return [
            'status' => Response::STATUS_SUCCESS
        ];
    }
    
    public function actionDeviceAdd()
    {
        
    }
   
}