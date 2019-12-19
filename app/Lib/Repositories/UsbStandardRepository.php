<?php


namespace App\Repositories;


use App\Models\UsbStandard;

class UsbStandardRepository
{
    public static function getAllAsArray()
    {
        $list = UsbStandard::find()
            ->select('id, standard as title')
            ->orderBy('standard')
            ->asArray()
            ->all()
            ;
        
        array_unshift($list, [
            'id' => 0,
            'title' => '-'
        ]);
        
        return $list;
    }
}