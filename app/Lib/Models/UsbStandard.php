<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class USBStandard
 * @package App\Models
 * 
 * @property int    $id         [integer(11)]
 * @property string $standard   [varchar(15)]
 * @property Device[]   $devices
 */
class UsbStandard extends ActiveRecord
{
    public static function tableName()
    {
        return 'usb_standard';
    }

    public function getDevices()
    {
        return $this
            ->hasMany(Device::class, ['id' => 'device_id'])
            ->viaTable(DeviceSpecification::tableName(), ['usb_standard_id' => 'id'])
            ;
    }
}