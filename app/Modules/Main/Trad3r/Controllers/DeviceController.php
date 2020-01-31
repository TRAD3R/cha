<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;
use App\Helpers\DeviceHelper;
use App\Models\Device;
use App\Models\DeviceSpecification;
use App\Params;
use App\Repositories\DeviceRepository;
use App\Request;
use App\Response;
use App\Tables\DeviceTableStructure;
use Yii;

class DeviceController extends Main
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        
        $params = [
            Params::GADGET          => (int)$request->get(Params::GADGET),
            Params::PAGE            => $request->get(Params::PAGE) ?: 1,
            Params::PER_PAGE        => $request->get(Params::PER_PAGE) ?: DeviceHelper::PER_PAGE,
            Params::SORT_ASC        => $request->getArrayStr(Params::SORT_ASC),
            Params::SORT_DESC       => $request->getArrayStr(Params::SORT_DESC),
        ];
        
        $offset = ($params[Params::PAGE] - 1) * $params[Params::PER_PAGE];
        
        $devices = new DeviceHelper();
        $devices = $devices->getDevices($params, $offset);

        return $this->render('index', [
            'devices' => $devices['items'],
            'totalCount' => $devices['total'],
            'params' => $params,
            'offset' => $offset,
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
    public function actionUpdate($id)
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

        $row = $this->renderPartial('includes/table_row', [
                'device' => $device, 
                'sequenceNumber' => $request->post('sequenceNumber') ?: 0
            ]
        );
        
        return [
            'status' => Response::STATUS_SUCCESS,
            'row' => $row,
        ];
    }
    
    public function actionAdd()
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

        $row = $this->renderPartial('includes/table_row', [
                'device' => $device,
                'sequenceNumber' => $request->post('sequenceNumber') ?: 0
            ]
        );

        return [
            'status' => Response::STATUS_SUCCESS,
            'row' => $row,
            'id' => $device->id,
        ];
    }

    public function actionRemove($id)
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if(!$request->isAjax() || !$request->isGet()) {
            $this->getResponse()->set404();
        }

        $device = Device::findOne($id);
        if(!$device || !$device->delete()) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'ERROR_DATA_UPDATE'),
            ];
        }
        
        return [
            'status' => Response::STATUS_SUCCESS,
        ];
    }
    
    public function actionSpecList($id)
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
    
    public function actionSearch()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if(!$request->isAjax() || !$request->isGet()) {
            $this->getResponse()->set404();
        }
        
        $models = DeviceRepository::getAllModelsAsArray();
        
        return [
            'status' => Response::STATUS_SUCCESS,
            'models' => $models
        ];
    }
   
}