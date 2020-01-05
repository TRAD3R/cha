<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class Device
 * @package App\Models
 * 
 * @property int                    $id                 [integer(11)]
 * @property int                    $date_created       [datetime]
 * @property string                 $title              [varchar(250)]
 * @property int                    $line_id            [integer(11)]
 * @property Device[]               $devices
 */
class Line extends ActiveRecord
{
    public static function tableName()
    {
        return 'lines';
    }

    public function getDevices()
    {
        return $this->hasMany(Device::class, ['id' => 'line_id']);
    }
}