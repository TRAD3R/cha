<?php


namespace App\Repositories;


use App\Models\Manufacturer;

class ManufacturerRepository
{
    public static function getAllAsArray()
    {
        return Manufacturer::find()
            ->select('id, name as title')
            ->orderBy('name')
            ->asArray()
            ->all()
            ;
    }

    public static function findOneByValue($value)
    {
        return Manufacturer::find()
            ->where(['name' => $value])
            ->one();
    }
}