<?php


namespace App\Repositories;


use App\Models\UsbType;

class UsbTypeRepository
{
    public static function getAllAsArray()
    {
        return UsbType::find()
            ->select('id, type as title')
            ->orderBy('type')
            ->asArray()
            ->all()
            ;
    }
}