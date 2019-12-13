<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class CardMemory
 * @package App\Models
 * 
 * @property int        $id         [integer(11)]
 * @property string     $size       [varchar(15)]
 * @property Device[]   $devices
 */
class CardMemory extends ActiveRecord
{
    public static function tableName()
    {
        return 'card_memory';
    }

    public function getDevices()
    {
        return $this
            ->hasMany(Device::class, ['id' => 'device_id'])
            ->viaTable(DeviceSpecification::tableName(), ['card_memory_id' => 'id'])
            ;
    }
}