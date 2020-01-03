<?php


namespace App\Helpers;


use App\Models\CardMemory;
use App\Models\Device;
use App\Models\DeviceBrand;
use App\Models\DeviceSpecification;
use App\Models\DeviceType;
use App\Models\Line;
use App\Models\UsbStandard;
use App\Models\UsbType;
use App\Params;
use App\Repositories\CardMemoryRepository;
use App\Repositories\DeviceBrandRepository;
use App\Repositories\DeviceTypeRepository;
use App\Repositories\UsbStandardRepository;
use App\Repositories\UsbTypeRepository;
use App\Tables\DeviceTableStructure;
use yii\db\Query;
use yii\db\QueryBuilder;

class DeviceHelper
{
    const PER_PAGE = 100;
    
    /** @var Query|null $query */
    private $query = null;
    
    public function getDevices($params, $offset)
    {
        $this->query = Device::find()
            ->alias('d')
            ->innerJoin('device_specifications s', 'd.id = s.device_id')
        ;
        
        if($params[Params::SORT_ASC]) {
            self::addSort($params[Params::SORT_ASC], 'ASC');
        }

        if($params[Params::SORT_DESC]) {
            self::addSort($params[Params::SORT_DESC], 'DESC');
        }
        
        $this->query
            ->addOrderBy('d.id ASC')
            ->limit($params[Params::PER_PAGE])
            ->offset($offset)
            ;
        
        return $this->query->all();
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
                case DeviceTableStructure::DEVICE_LINE:
                    $line = Line::findOne($value);

                    if(!$line){
                        $line = new Line();
                        $line->title = $value;
                        $line->save();
                    }

                    $device->line_id = $line->id;
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
    
    private function addSort($params, $type)
    {
        $uniqParam = $type == 'ASC' ? 1 : 2;
        
        foreach ($params as $param) {
            switch ($param) {
                case DeviceTableStructure::DEVICE_TYPE:
                    $this->query
                        ->innerJoin('device_type dt' . $uniqParam, "dt{$uniqParam}.id = s.type_id")
                        ->addOrderBy("dt{$uniqParam}.type $type");
                    break;
                case DeviceTableStructure::DEVICE_BRAND:
                    $this->query
                        ->innerJoin('device_brand db' . $uniqParam, "db{$uniqParam}.id = d.brand_id")
                        ->addOrderBy("db{$uniqParam}.name $type");
                    break;
                case DeviceTableStructure::DEVICE_MODEL:
                    $this->query
                        ->addOrderBy("d.title $type");
                    break;
                case DeviceTableStructure::DEVICE_YEAR:
                    $this->query
                        ->addOrderBy("s.year $type");
                    break;
                case DeviceTableStructure::DEVICE_LENGTH:
                    $this->query
                        ->addOrderBy("s.length $type");
                    break;
                case DeviceTableStructure::DEVICE_WIDTH:
                    $this->query
                        ->addOrderBy("s.width $type");
                    break;
                case DeviceTableStructure::DEVICE_DEPTH:
                    $this->query
                        ->addOrderBy("s.depth $type");
                    break;
                case DeviceTableStructure::DEVICE_SCREEN_SIZE:
                    $this->query
                        ->addOrderBy("s.screensize $type");
                    break;
                case DeviceTableStructure::DEVICE_CARD_MEMORY:
                    $this->query
                        ->innerJoin('card_memory cm' . $uniqParam, "cm{$uniqParam}.id = s.card_memory_id")
                        ->addOrderBy("cm{$uniqParam}.size $type");
                    break;
                case DeviceTableStructure::DEVICE_35_JACK:
                    $this->query
                        ->addOrderBy("s.jack_35 $type");
                    break;
                case DeviceTableStructure::DEVICE_BLUETOOTH:
                    $this->query
                        ->addOrderBy("s.bluetooth $type");
                    break;
                case DeviceTableStructure::DEVICE_USB_TYPE:
                    $this->query
                        ->innerJoin('usb_type ut' . $uniqParam, "ut{$uniqParam}.id = s.usb_type_id")
                        ->addOrderBy("ut{$uniqParam}.type $type");
                    break;
                case DeviceTableStructure::DEVICE_USB_STANDARD:
                    $this->query
                        ->innerJoin('usb_standard us' . $uniqParam, "us{$uniqParam}.id = s.usb_standard_id")
                        ->addOrderBy("us{$uniqParam}.standard $type");
                    break;
                case DeviceTableStructure::DEVICE_WIRELESS_CHARGE:
                    $this->query
                        ->addOrderBy("s.wireless_charge $type");
                    break;
                case DeviceTableStructure::DEVICE_FAST_CHARGE:
                    $this->query
                        ->addOrderBy("s.fasst_charge $type");
                    break;
                case DeviceTableStructure::DEVICE_REMOVABLE_BATTERY:
                    $this->query
                        ->addOrderBy("s.removable_battery $type");
                    break;
                case DeviceTableStructure::DEVICE_PRICE:
                    $this->query
                        ->addOrderBy("s.price $type");
                    break;
            }
        }
    }
}