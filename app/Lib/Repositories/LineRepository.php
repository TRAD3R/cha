<?php


namespace App\Repositories;


use App\Models\Line;

class LineRepository
{
    public static function getAllAsArray()
    {
        $list = Line::find()
            ->select('id, title as title')
            ->orderBy('title')
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