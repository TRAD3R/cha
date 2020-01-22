<?php


namespace Main\Trad3r\Controllers;


use App\App;
use App\Controller\Main;
use App\Helpers\ListingHelper;
use App\Helpers\ProductHelper;
use App\Models\Product;
use App\Params;
use App\Request;
use App\Response;
use Yii;

class ListingController extends Main
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        $params = [
            Params::LISTING_TYPE => $request->get(Params::LISTING_TYPE),
            Params::PAGE        => $request->get(Params::PAGE) ?: 1,
            Params::PER_PAGE    => $request->get(Params::PER_PAGE) ?: ProductHelper::PER_PAGE,
            Params::SORT_ASC    => $request->getArrayStr(Params::SORT_ASC),
            Params::SORT_DESC   => $request->getArrayStr(Params::SORT_DESC),
        ];

        $offset = ($params[Params::PAGE] - 1) * $params[Params::PER_PAGE];
        
        $products = (new ProductHelper())->getProducts([], 0);
        return $this->render('index', [
            'products' => $products['products'],
            'totalCount' => $products['total'],
            'params' => $params,
            'offset' => $offset
        ]);
    }
    
    public function actionCreate()
    {
        $this->getResponse()->setJsonFormat();
        /** @var Request $request */
        $request = $this->getRequest();
        
        $params = [
            ListingHelper::FILENAME => $request->post(ListingHelper::FILENAME, date('Y-m-d-H-m-s', time())),
            ListingHelper::IDS => $request->post(ListingHelper::IDS, []),
            Params::LISTING_TYPE => $request->post(Params::LISTING_TYPE),
            Params::LISTING_ACTION_TYPE => $request->post(Params::LISTING_ACTION_TYPE),
        ];
        
        $filename = $params[ListingHelper::FILENAME] . "." . ListingHelper::FILETYPE;
        
        if(!ListingHelper::isUniqueFilename($filename)){
            return [
                'status' => Response::STATUS_FAIL,
                'error'  => Yii::t('front', 'FILENAME_IS_NOT_UNIQUE', ['filename' => $filename])
            ];
        }
        
        $helper = new ListingHelper();
        $products = null;
        
        if($params[Params::LISTING_TYPE] === ListingHelper::PRODUCTS) {
            $products = Product::findAll($params[ListingHelper::IDS]);
            
            if($helper->create($products, $filename, $params[Params::LISTING_ACTION_TYPE])){

                return [
                    'status' => Response::STATUS_SUCCESS,
                    'href' => App::i()->getFile()->mdUrl("/out/" . $filename),
                    'file' => $filename,
                ];
            }
            
        }elseif($params[Params::LISTING_TYPE] === ListingHelper::PRODUCTS){
            
        }elseif($params[Params::LISTING_TYPE] === ListingHelper::LINES){

        }

        return [
            'status' => Response::STATUS_FAIL,
        ];
    }

    /** @todo Реализовать прогрессбар */
    public function actionProgress()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        
        if(!$request->isAjax()){
            $this->getResponse()->set404();
        }
        
        $this->getResponse()->setJsonFormat();
        return [
            'status' => Response::STATUS_SUCCESS,
            'progress' => (new ListingHelper())->getProgress(),
        ];
    }
}