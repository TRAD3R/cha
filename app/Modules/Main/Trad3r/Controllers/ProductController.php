<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;
use App\Helpers\ProductHelper;
use App\Models\Product;
use App\Params;
use App\Request;
use App\Response;
use Yii;

class ProductController extends Main
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        
        $params = [
            Params::PAGE        => $request->get(Params::PAGE) ?: 1,
            Params::PER_PAGE    => $request->get(Params::PER_PAGE) ?: ProductHelper::PER_PAGE,
            Params::SORT_ASC    => $request->getArrayStr(Params::SORT_ASC),
            Params::SORT_DESC   => $request->getArrayStr(Params::SORT_DESC),
        ];
        
        $offset = ($params[Params::PAGE] - 1) * $params[Params::PER_PAGE];
        
        $products = new ProductHelper();
        $products = $products->getProducts($params, $offset);
        
        return $this->render('index', [
            'products' => $products['items'],
            'totalCount' => $products['total'],
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
    public function actionUpdate($id)
    {
        /** @var Request $request */
        $request = $this->getRequest();
        
        if(!$request->isAjax() || !$request->isPost()) {
            $this->getResponse()->set404();
        }

        $product = Product::findOne($id);
        if (!$product) {
            Yii::error(Yii::t('exception', 'DEVICE_NOT_FOUND', ['id' => $id]));
        }
        
        $data = $request->post();
        
        if(count($data) == 0) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'NO_DATA_TO_UPDATE'),
            ];
        }
        
        if(!ProductHelper::modifyData($product, $data)) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'ERROR_DATA_UPDATE'),
            ];
        }

        $view = 'table_row_parent';
        
        if($product->parent_id == -1){
            $view = 'table_row_individual';
        }elseif ($product->parent_id) {
            $view = 'table_row_child';
        }

        $row = $this->renderPartial('includes/' . $view, [
                'product' => $product,
            ]
        );
        
        return [
            'status' => Response::STATUS_SUCCESS,
            'row' => $row,
        ];
    }
    
    public function actionAdd($id)
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

        $product = new Product();
        if($id == Product::TYPE_INDIVIDUAL) {
            $product->parent_id = Product::TYPE_INDIVIDUAL;
        }
        if(!ProductHelper::modifyData($product, $data)) {
            return [
                'status' => Response::STATUS_FAIL,
                'error' => Yii::t('exception', 'ERROR_DATA_UPDATE'),
            ];
        }
        
        $view = 'table_row_parent';

        if($product->parent_id == Product::TYPE_INDIVIDUAL){
            $view = 'table_row_individual';
        }elseif ($product->parent_id) {
            $view = 'table_row_child';
        }
        
        $row = $this->renderPartial('includes/' . $view, [
                'product' => $product,
            ]
        );

        return [
            'status' => Response::STATUS_SUCCESS,
            'row' => $row,
            'id' => $product->id
        ];
    }

    public function actionRemove($id)
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if(!$request->isAjax() || !$request->isGet()) {
            $this->getResponse()->set404();
        }

        $product = Product::findOne($id);
        if(!$product || !$product->delete()) {
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
            'list' => ProductHelper::getSpecificationList($id),
        ];
    }
   
}