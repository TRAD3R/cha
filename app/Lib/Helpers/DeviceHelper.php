<?php


namespace App\Helpers;


use App\Models\CardMemory;
use App\Models\Device;
use App\Models\DeviceBrand;
use App\Models\DeviceSpecification;
use App\Models\DeviceType;
use App\Models\UsbStandard;
use App\Models\UsbType;
use App\Params;
use App\Repositories\CardMemoryRepository;
use App\Repositories\DeviceBrandRepository;
use App\Repositories\DeviceTypeRepository;
use App\Repositories\UsbStandardRepository;
use App\Repositories\UsbTypeRepository;
use App\Tables\DeviceTableStructure;

class DeviceHelper
{
    const PER_PAGE = 100;
    
    public static function getDevices($limit, $offset, $sort = Params::SORT_TYPE_TITLE)
    {
        $query = Device::find()
            ->alias('d')
        ;
        
        switch ($sort) {
            case Params::SORT_TYPE_TITLE:
                $query
                    ->innerJoin('device_brand b', 'd.brand_id = b.id')
                    ->orderBy([
                        'b.name' => 'ASC', 
                        'd.title' => 'ASC'
                    ])
                ;
        }
        
        $query->limit($limit)
            ->offset($offset)
            ;
        
        return $query->all();
    }
    
    public static function modifyData(Device $device, array $data)
    {
        /** @var DeviceSpecification $specifications */
        $specifications = $device->id ? $device->specifications : new DeviceSpecification();
        
        foreach ($data as $key => $value) {
            switch ($key) {
                case DeviceTableStructure::DEVICE_TYPE:
                    $deviceType = DeviceType::findOne($value);

                    if(!$deviceType){
                        $deviceType = new DeviceType();
                        $deviceType->type = $value;
                        $deviceType->save();
                    }

                    $specifications->type_id = $deviceType->id;
                    break;
                case DeviceTableStructure::DEVICE_BRAND:
                    $brand = DeviceBrand::findOne($value);
                    
                    if(!$brand){
                        $brand = new DeviceBrand();
                        $brand->name = $value;
                        $brand->save();
                    }

                    $device->brand_id = $brand->id;
                    break;
                case DeviceTableStructure::DEVICE_MODEL:
                    $device->title = $value;
                    break;
                case DeviceTableStructure::DEVICE_YEAR:
                    $specifications->year = $value;
                    break;
                case DeviceTableStructure::DEVICE_LENGTH:
                    $specifications->length = $value;
                    break;
                case DeviceTableStructure::DEVICE_WIDTH:
                    $specifications->width = $value;
                    break;
                case DeviceTableStructure::DEVICE_DEPTH:
                    $specifications->depth = $value;
                    break;
                case DeviceTableStructure::DEVICE_SCREEN_SIZE:
                    $specifications->screensize = $value;
                    break;
                case DeviceTableStructure::DEVICE_CARD_MEMORY:
                    $cardMemory = CardMemory::findOne($value);
                    
                    if(!$cardMemory) {
                        $cardMemory = new CardMemory();
                        $cardMemory->size = $value;
                        $cardMemory->save();
                    }
                    
                    $specifications->card_memory_id = $cardMemory->id;
                    break;
                case DeviceTableStructure::DEVICE_35_JACK:
                    $specifications->jack_35 = $value;
                    break;
                case DeviceTableStructure::DEVICE_BLUETOOTH:
                    $specifications->bluetooth = $value;
                    break;
                case DeviceTableStructure::DEVICE_USB_TYPE:
                    $usbType = UsbType::findOne($value);
                        
                    if(!$usbType) {
                        $usbType = new UsbType();
                        $usbType->type = $value;
                        $usbType->save();
                    }

                    $specifications->usb_type_id = $usbType->id;
                    break;
                case DeviceTableStructure::DEVICE_USB_STANDARD:
                    $usbStardard = UsbStandard::findOne($value);
                    
                    if(!$usbStardard) {
                        $usbStardard = new UsbStandard();
                        $usbStardard->standard = $value;
                        $usbStardard->save();
                    }

                    $specifications->usb_standard_id = $usbStardard->id;
                    break;
                case DeviceTableStructure::DEVICE_WIRELESS_CHARGE:
                    $specifications->wireless_charge = $value;
                    break;
                case DeviceTableStructure::DEVICE_FAST_CHARGE:
                    $specifications->fast_charge = $value;
                    break;
                case DeviceTableStructure::DEVICE_REMOVABLE_BATTERY:
                    $specifications->removable_battery = $value;
                    break;
                case DeviceTableStructure::DEVICE_PRICE:
                    $specifications->price = PriceHelper::toInt($value);
                    break;
                case DeviceTableStructure::DEVICE_IMAGE:
                    $specifications->image = $value;
                    break;
            }
        }
        
        if($device->id) {
            return ($device->save() && $specifications->save());
        }else{
            if($device->save()) {
                $specifications->device_id = $device->id;
                return $specifications->save();
            }else{
                \Yii::error($device->getErrors());
                return false;
            }
        }
        
    }
    
    public static function getSpecificationList($id)
    {
        $list = [];
        switch ($id) {
            case DeviceTableStructure::DEVICE_TYPE:
                $list = DeviceTypeRepository::getAllAsArray();
                break;
            case DeviceTableStructure::DEVICE_BRAND:
                $list = DeviceBrandRepository::getAllAsArray();
                break;
            case DeviceTableStructure::DEVICE_CARD_MEMORY:
                $list = CardMemoryRepository::getAllAsArray();
                break;
            case DeviceTableStructure::DEVICE_USB_TYPE:
                $list = UsbTypeRepository::getAllAsArray();
                break;
            case DeviceTableStructure::DEVICE_USB_STANDARD:
                $list = UsbStandardRepository::getAllAsArray();
                break;
        }
        
        return $list;
    }
}