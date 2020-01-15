<?php


namespace App\Repositories;


use App\Models\VariationTheme;

class VariationThemeRepository
{
    public static function getAllAsArray()
    {
        return VariationTheme::find()
            ->select('id, title')
            ->orderBy('title')
            ->asArray()
            ->all()
            ;
    }

    public static function findOneByValue($value)
    {
        return VariationTheme::find()
            ->where(['title' => $value])
            ->one();
    }
}