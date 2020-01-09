<?php


namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public static function getTypeAsArray($type = null)
    {
        $arr = [];
        $types = (new Product())->getProductType($type);

        foreach ($types as $key => $title) {
            $arr[$key]['id'] = $key;
            $arr[$key]['title'] = $title;
        }
        
        return $arr;
    }

    public static function getParentsAsArray()
    {
        return Product::find()
            ->select('id, id as title')
            ->orderBy('id')
            ->asArray()
            ->all()
            ;
    }
}