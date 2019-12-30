<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class BarcodeType
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     $type           [varchar(20)]
 */
class BarcodeType extends ActiveRecord
{
    public static function tableName()
    {
        return 'barcode_types';
    }
}