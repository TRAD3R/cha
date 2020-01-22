<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class ProductType
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     $type           [varchar(50)]
 * @property string     $alias          [varchar(50)]
 */
class ProductType extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_types';
    }
}