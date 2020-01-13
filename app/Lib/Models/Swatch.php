<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class Swatch
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     title           [varchar(30)]
 * @property string     filename           [varchar(30)]
 */
class Swatch extends ActiveRecord
{
    public static function tableName()
    {
        return 'swatches';
    }
}