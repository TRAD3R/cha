<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class Merchant
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     $name           [varchar(50)]
 */
class Merchant extends ActiveRecord
{
    public static function tableName()
    {
        return 'merchants';
    }
}