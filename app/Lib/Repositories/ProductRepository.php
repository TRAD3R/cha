<?php


namespace App\Repositories;

use App\Models\Product;
use Yii;

class ProductRepository
{
    public static function getParentsAsArray()
    {
        return Product::find()
            ->select('id, id as title')
            ->where(['parent_id' => null])
            ->orderBy('id')
            ->asArray()
            ->all()
            ;
    }

    public static function getNodeAsArray()
    {
        $arr = [];
        $nodes = [
            1 => Yii::t('front', 'PARENT'),
            2 => Yii::t('front', 'CHILD'),
        ];

        foreach ($nodes as $key => $title) {
            $arr[$key]['id'] = $key;
            $arr[$key]['title'] = $title;
        }

        return $arr;
    }

    public static function findAllParentOrIndiv()
    {
        return Product::find()
            ->where(['parent_id' => null])
            ->orWhere(['parent_id' => -1])
            ->all()
        ;
    }
}