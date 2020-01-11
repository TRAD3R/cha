<?php


namespace App\Repositories;

use App\Models\ProductBrand;

class ProductBrandRepository
{
    public static function getAllAsArray()
    {
        return ProductBrand::find()
            ->select('id, name as title')
            ->orderBy('name')
            ->asArray()
            ->all()
            ;
    }

    public static function findOneByValue($value)
    {
        return ProductBrand::find()
            ->where(['name' => $value])
            ->one();
    }
}