<?php


namespace App\Repositories;


use App\Models\BrowseNode;

class BrowseNodeRepository
{
    public static function getAllAsArray()
    {
        return BrowseNode::find()
            ->select('id, product_type as title')
            ->orderBy('product_type')
            ->asArray()
            ->all()
            ;
    }

    public static function findByValue($value)
    {
        return BrowseNode::find()
            ->where(['product_type' => $value])
            ->one();
    }
}