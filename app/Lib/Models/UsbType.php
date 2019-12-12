<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class USBType
 * @package App\Models
 * 
 * @property int        $id         [integer(11)]
 * @property string     $type       [varchar(15)]
 * @property Device[]   $devices
 */
class UsbType extends ActiveRecord
{
    public static function tableName()
    {
        return 'usb_type';
    }

    public function getDevices()
    {
        return $this
            ->hasMany(Device::class, ['id' => 'device_id'])
            ->viaTable(DeviceSpecification::tableName(), ['usb_type_id' => 'id'])
            ;
    }
}