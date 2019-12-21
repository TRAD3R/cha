<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class VariationTheme
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property string     $title           [varchar(50)]
 */
class VariationTheme extends ActiveRecord
{
    public static function tableName()
    {
        return 'variation_themes';
    }
}