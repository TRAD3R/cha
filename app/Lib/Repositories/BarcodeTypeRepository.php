<?php


namespace App\Repositories;


use App\Models\BarcodeType;

class BarcodeTypeRepository
{
    public static function getAllAsArray()
    {
        return BarcodeType::find()
            ->select('id, type as title')
            ->orderBy('type')
            ->asArray()
            ->all()
            ;
    }

    public static function findOneByValue($value)
    {
        return BarcodeType::findOne(['type' => $value]);
    }
}