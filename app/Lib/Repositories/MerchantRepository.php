<?php


namespace App\Repositories;


use App\Models\Merchant;

class MerchantRepository
{
    public static function getAllAsArray()
    {
        return Merchant::find()
            ->select('id, name as title')
            ->orderBy('name')
            ->asArray()
            ->all()
            ;
    }
}