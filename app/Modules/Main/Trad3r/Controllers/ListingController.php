<?php


namespace Main\Trad3r\Controllers;


use App\App;
use App\Controller\Main;
use App\Helpers\DeviceHelper;
use App\Helpers\ListingHelper;
use App\Helpers\ProductHelper;
use App\Models\Device;
use App\Models\Product;
use App\Params;
use App\Repositories\DeviceRepository;
use App\Repositories\ProductRepository;
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
            Params::SORT_DATE_FROM   => $request->get(Params::SORT_DATE_FROM),
            Params::SORT_DATE_TO   => $request->get(Params::SORT_DATE_TO),
            Params::PRODUCTS   => $request->getArrayStr(Params::PRODUCTS),
        ];

        $offset = ($params[Params::PAGE] - 1) * $params[Params::PER_PAGE];


        $products = [];

        switch($params[Params::LISTING_TYPE]){
            case ListingHelper::DEVICES:
                $products =(new ProductHelper())->getProducts([], 0);
                if($params[Params::PRODUCTS]) {
                    $selectedProducts = Product::find()->where(["IN", 'id', $params[Params::PRODUCTS]])->all();
                }else{
                    $selectedProducts = [];
                }
                    
                $gadgets = DeviceRepository::getAllDevicesLinkToProduct($selectedProducts, [], $params, $offset);
                break;
            case ListingHelper::PRODUCTS:
            default:
                $gadgets = (new ProductHelper())->getProducts($params, $offset);
        }
        
        $params[Params::SORT_DATE_FROM] = $gadgets[Params::SORT_DATE_FROM];
        $params[Params::SORT_DATE_TO] = $gadgets[Params::SORT_DATE_TO];

        return $this->render('index', [
            'gadgets' => $gadgets['items'],
            'totalCount' => $gadgets['total'],
            'products' => $products['items'],
            'params' => $params,
            'offset' => $offset,
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

        $helper = new ListingHelper($filename, $params[Params::LISTING_ACTION_TYPE]);
        $createFile = [];
        $products = null;
        $devices = null;

        if($params[Params::LISTING_TYPE] === ListingHelper::PRODUCTS) {
            $products = Product::findAll($params[ListingHelper::IDS]);
            $createFile = $helper->createListing($products);
            
        }elseif($params[Params::LISTING_TYPE] === ListingHelper::DEVICES){
            $products = ProductRepository::findAllParentOrIndiv();
            $createFile = $helper->createListing($products, $params[ListingHelper::IDS]);
            
        }elseif($params[Params::LISTING_TYPE] === ListingHelper::LINES){

        }

        if($createFile['status']){
            return [
                'status' => Response::STATUS_SUCCESS,
                'href' => App::i()->getFile()->mdUrl("/out/" . $filename),
                'file' => $filename,
                'errors' => $createFile['errors'],
            ];
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
        echo 25;
        exit;
        return [
            'status' => Response::STATUS_SUCCESS,
            'progress' => file_get_contents(Yii::getAlias('@web') . "/files/progress"),
        ];
    }

    public function actionArchive()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if(!$request->isAjax()){
            $this->getResponse()->set404();
        }

        $files = ListingHelper::getAllFiles();

        $this->getResponse()->setJsonFormat();
        return [
            'status' => Response::STATUS_SUCCESS,
            'files' => $files,
        ];
    }
}