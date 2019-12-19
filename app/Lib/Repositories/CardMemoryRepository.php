<?php


namespace App\Repositories;


use App\Models\CardMemory;

class CardMemoryRepository
{
    public static function getAllAsArray()
    {
        return CardMemory::find()
            ->select('id, size as title')
            ->orderBy('size')
            ->asArray()
            ->all()
            ;
    }
}