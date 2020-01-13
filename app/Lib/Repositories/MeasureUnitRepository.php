<?php


namespace App\Repositories;


use App\Models\MeasureUnit;

class MeasureUnitRepository
{
    public static function getAllAsArray()
    {
        return MeasureUnit::find()
            ->select('id, type as title')
            ->orderBy('type')
            ->asArray()
            ->all()
            ;
    }

    public static function findOneByValue($value)
    {
        return MeasureUnit::find()
            ->where(['type' => $value])
            ->one();
    }
}