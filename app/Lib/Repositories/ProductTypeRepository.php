<?php


namespace App\Repositories;

use App\Models\ProductType;

class ProductTypeRepository
{
    public static function getAllAsArray()
    {
        return ProductType::find()
            ->select('id, type as title')
            ->orderBy('type')
            ->asArray()
            ->all()
            ;
    }
    
    public static function findByValue($value)
    {
        return ProductType::find()->where(['type' => $value])->one();
    }
}