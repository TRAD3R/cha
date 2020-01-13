<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class BarcodeType
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     $name           [varchar(30)]
 */
class Swatch extends ActiveRecord
{
    public static function tableName()
    {
        return 'swatches';
    }
}