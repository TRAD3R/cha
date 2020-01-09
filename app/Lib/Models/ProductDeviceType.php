<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class ProductDeviceType
 * @package App\Models
 * 
 * @property int     $product_id         [integer(11)]
 * @property int     $device_type_id     [integer(11)]
 */
class ProductDeviceType extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_device_type';
    }
}