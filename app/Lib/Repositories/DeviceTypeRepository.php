<?php


namespace App\Repositories;


use App\Models\DeviceType;

class DeviceTypeRepository
{
    public static function getAllAsArray()
    {
        return DeviceType::find()
            ->select('id, type as title')
            ->orderBy('type')
            ->asArray()
            ->all()
            ;
    }
}