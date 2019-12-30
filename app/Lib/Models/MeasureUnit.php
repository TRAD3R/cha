<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class MeasureUnit
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     $type           [varchar(10)]
 */
class MeasureUnit extends ActiveRecord
{
    public static function tableName()
    {
        return 'measure_units';
    }
}