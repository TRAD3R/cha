<?php


namespace App\Repositories;


use App\Models\DeviceBrand;

class DeviceBrandRepository
{
    public static function getAllAsArray()
    {
        return DeviceBrand::find()
            ->select('id, name as title')
            ->orderBy('name')
            ->asArray()
            ->all()
            ;
    }
}