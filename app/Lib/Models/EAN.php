<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class EAN
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property int        $date_created   [datetime]
 * @property int        $date_updated   [datetime]
 * @property string     $ean            [varchar(50)]
 * @property boolean    $is_used        [bit(1)]
 */
class EAN extends ActiveRecord
{
    public static function tableName()
    {
        return 'eans';
    }

    public function behaviors()
    {
        return [
            Timestamp::class
        ];
    }
}