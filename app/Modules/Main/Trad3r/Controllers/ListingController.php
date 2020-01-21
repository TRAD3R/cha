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
        ];
        $filename = $params[ListingHelper::FILENAME] . "." . ListingHelper::FILETYPE;
        $helper = new ListingHelper();
        $products = Product::findAll($params[ListingHelper::IDS]);
        if($helper->create($products, $filename)){
            
            return [
                'status' => Response::STATUS_SUCCESS,
                'href' => App::i()->getFile()->mdUrl("/out/" . $filename),
                'file' => $filename,
            ];
        }

        return [
            'status' => Response::STATUS_FAIL,
        ];
    }
}