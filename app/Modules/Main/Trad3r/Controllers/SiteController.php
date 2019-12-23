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

    /**
     * Изменение параметров девайса
     * 
     * @param $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     * @throws \yii\web\HttpException
     */
    public function actionDeviceUpdate($id)
    {
        /** @var Request $request */
        $request = $this->getRequest();
        
        if(!$request->isAjax() || !$request->isPost()) {
            $this->getResponse()->set404();
        }

        $device = Device::findOne($id);
        if (!$device) {
            Yii::error(Yii::t('exception', 'DEVICE_NOT_FOUND', ['id' => $id]));
        }
        
        $data = $request->post();
        
        if(count($data) == 0) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'NO_DATA_TO_UPDATE'),
            ];
        }
        
        if(!DeviceHelper::modifyData($device, $data)) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'ERROR_DATA_UPDATE'),
            ];
        }

        $row = $this->renderPartial('includes/device/table_row', [
                'device' => $device, 
                'sequenceNumber' => $request->post('sequenceNumber') ?: 0
            ]
        );
        
        return [
            'status' => Response::STATUS_SUCCESS,
            'row' => $row,
        ];
    }
    
    public function actionDeviceAdd()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if(!$request->isAjax() || !$request->isPost()) {
            $this->getResponse()->set404();
        }

        $data = $request->post();

        if(count($data) == 0) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'NO_DATA_TO_UPDATE'),
            ];
        }

        $device = new Device();
        if(!DeviceHelper::modifyData($device, $data)) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'ERROR_DATA_UPDATE'),
            ];
        }

        $row = $this->renderPartial('includes/device/table_row', [
                'device' => $device,
                'sequenceNumber' => $request->post('sequenceNumber') ?: 0
            ]
        );

        return [
            'status' => Response::STATUS_SUCCESS,
            'row' => $row,
        ];
    }
    
    public function actionDeviceSpecList($id)
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if(!$request->isAjax() || !$request->isGet()) {
            $this->getResponse()->set404();
        }

        return [
            'status' => Response::STATUS_SUCCESS,
            'list' => DeviceHelper::getSpecificationList($id),
        ];
    }
   
}