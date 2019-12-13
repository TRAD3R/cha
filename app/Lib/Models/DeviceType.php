<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class DeviceType
 * @package App\Models
 * 
 * @property int        $id         [integer(11)]
 * @property string     $type       [varchar(100)]
 * @property Device[]   $devices
 */
class DeviceType extends ActiveRecord
{
    public static function tableName()
    {
        return 'device_type';
    }
    
    public function getDevices()
    {
        return $this
            ->hasMany(Device::class, ['id' => 'device_id'])
            ->viaTable(DeviceSpecification::tableName(), ['device_type_id' => 'id'])
            ;
    }
}