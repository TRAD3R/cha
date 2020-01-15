<?php


namespace App\Repositories;


use App\Models\BrowseNode;

class BrowseNodeRepository
{
    public static function getAllAsArray()
    {
        return BrowseNode::find()
            ->select('id, title')
            ->orderBy('title')
            ->asArray()
            ->all()
            ;
    }

    public static function findOneByValue($value)
    {
        return BrowseNode::find()
            ->where(['title' => $value])
            ->one();
    }
}