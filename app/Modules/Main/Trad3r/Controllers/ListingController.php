<?php


namespace Main\Trad3r\Controllers;


use App\Controller\Main;
use App\Helpers\ProductHelper;
use App\Params;
use App\Request;

class ListingController extends Main
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
        
        $products = (new ProductHelper())->getProducts([], 0);
        return $this->render('index', [
            'products' => $products['products'],
            'totalCount' => $products['total'],
            'params' => $params,
            'offset' => $offset
        ]);
    }
}