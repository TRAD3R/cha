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
        $specifications = $device->specifications;
        
        foreach ($data as $key => $value) {
            switch ($key) {
                case DeviceTableStructure::DEVICE_TYPE:
                    $specifications->type_id = $value;
                    break;
                case DeviceTableStructure::DEVICE_BRAND:
                    if($brand = DeviceBrand::findOne($value)){
                        $device->brand = $brand;
                    }
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
                    if($cardMemory = CardMemory::findOne($value)) {
                        $specifications->cardMemory = $cardMemory;
                    }
                    break;
                case DeviceTableStructure::DEVICE_35_JACK:
                    $specifications->jack_35 = $value;
                    break;
                case DeviceTableStructure::DEVICE_BLUETOOTH:
                    $specifications->bluetooth = $value;
                    break;
                case DeviceTableStructure::DEVICE_USB_TYPE:
                    if($usbType = UsbType::findOne($value)) {
                        $specifications->usbType = $usbType;
                    }
                    break;
                case DeviceTableStructure::DEVICE_USB_STANDARD:
                    if($usbStardard = UsbStandard::findOne($value)) {
                        $specifications->usbStandard = $usbStardard;
                    }
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
        
        return ($device->save() && $specifications->save());
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