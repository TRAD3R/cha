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
}