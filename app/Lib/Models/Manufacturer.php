<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class Manufacturer
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     $name           [varchar(50)]
 */
class Manufacturer extends ActiveRecord
{
    public static function tableName()
    {
        return 'manufacturers';
    }
}