<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class Device
 * @package App\Models
 * 
 * @property int            $id         [integer(11)]
 * @property string         $title      [varchar(250)]
 * @property int            $brand_id   [integer(11)]
 * @property DeviceBrand    $brand
 * @property DeviceType     $type
 * @property CardMemory     $cardMemory
 * @property UsbType        $usbType
 * @property UsbStandard    $usbStandard
 */
class Device extends ActiveRecord
{
    public static function tableName()
    {
        return 'devices';
    }
    
    public function getBrand()
    {
        return $this->hasOne(DeviceBrand::class, ['id' => 'brand_id']);
    }

    public function getType()
    {
        return $this
            ->hasOne(DeviceType::class, ['id' => 'type_id'])
            ->viaTable(DeviceSpecification::tableName(), ['device_id' => 'id'])
            ;
    }

    public function getCardMemory()
    {
        return $this
            ->hasOne(CardMemory::class, ['id' => 'card_memory_id'])
            ->viaTable(DeviceSpecification::tableName(), ['device_id' => 'id'])
            ;
    }

    public function getUSBType()
    {
        return $this
            ->hasOne(UsbType::class, ['id' => 'usb_type_id'])
            ->viaTable(DeviceSpecification::tableName(), ['device_id' => 'id'])
            ;
    }

    public function getUSBStandard()
    {
        return $this
            ->hasOne(UsbStandard::class, ['id' => 'usb_standard_id'])
            ->viaTable(DeviceSpecification::tableName(), ['device_id' => 'id'])
            ;
    }
}