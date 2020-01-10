<?php


namespace App\Helpers;


use App\Models\DeviceType;
use App\Models\Manufacturer;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductSpecification;
use App\Models\ProductType;
use App\Models\VariationTheme;
use App\Params;
use App\Repositories\BarcodeTypeRepository;
use App\Repositories\BrowseNodeRepository;
use App\Repositories\DeviceTypeRepository;
use App\Repositories\ManufacturerRepository;
use App\Repositories\MerchantRepository;
use App\Repositories\ProductBrandRepository;
use App\Repositories\ProductRepository;
use App\Repositories\MeasureUnitRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\VariationThemeRepository;
use App\Tables\DeviceTableStructure;
use App\Tables\ProductTableStructure;
use Yii;
use yii\db\Query;
use yii\web\HttpException;

class ProductHelper
{
    const PER_PAGE = 100;
    
    /** @var Query|null $query */
    private $query = null;
    
    public function getProducts($params, $offset)
    {
        $this->query = Product::find()
            ->alias('p')
            ->innerJoin('product_specifications s', 'p.id = s.product_id')
        ;
        
        if($params[Params::SORT_ASC]) {
            self::addSort($params[Params::SORT_ASC], 'ASC');
        }

        if($params[Params::SORT_DESC]) {
            self::addSort($params[Params::SORT_DESC], 'DESC');
        }

        $total = $this->query->count();
        
        $this->query
            ->addOrderBy('p.id ASC')
            ->limit($params[Params::PER_PAGE])
            ->offset($offset)
            ;
        
        return [
            'products' => $this->query->all(),
            'total'   => $total
        ];
    }
    
    public static function modifyData(Product $product, array $data)
    {
        /** @var ProductSpecification $specifications */
        $specifications = $product->id ? $product->specifications : new ProductSpecification();
        
        foreach ($data as $key => $value) {
            switch ($key) {
                case ProductTableStructure::PARENT_ID:
                    $parent = Product::findOne($value);

                    if(!$parent){
                        throw new HttpException(403, Yii::t('exception', 'ERROR_DATA_UPDATE'));
                    }

                    $product->link('parent', $parent);
                    break;
                case ProductTableStructure::TYPE:
                    $type = ProductTypeRepository::findByValue($value);

                    if($type){
                        $specifications->type_id = $type->id;
                    }
                    break;
                case ProductTableStructure::MERCHANT:
                    $merchant = MerchantRepository::findByValue($value);

                    if(!$merchant){
                        $merchant = new Merchant();
                        $merchant->name = $value;
                        $merchant->save();
                    }

                    $specifications->merchant_id = $merchant->id;
                    break;
                case ProductTableStructure::MANUFACTURER:
                    $manufacturer = ManufacturerRepository::findByValue($value);

                    if(!$manufacturer){
                        $manufacturer = new Manufacturer();
                        $manufacturer->name = $value;
                        $manufacturer->save();
                    }
                    
                    $specifications->manufacturer_id = $manufacturer->id;
                    break;
                case ProductTableStructure::TITLE:
                    $product->name = $value;
                    break;
//                case ProductTableStructure::DEVICE_LENGTH:
//                    $specifications->length = $value;
//                    break;
//                case ProductTableStructure::DEVICE_WIDTH:
//                    $specifications->width = $value;
//                    break;
//                case ProductTableStructure::DEVICE_DEPTH:
//                    $specifications->depth = $value;
//                    break;
//                case ProductTableStructure::DEVICE_SCREEN_SIZE:
//                    $specifications->screensize = $value;
//                    break;
//                case ProductTableStructure::DEVICE_CARD_MEMORY:
//                    $cardMemory = CardMemory::findOne($value);
//                    
//                    if(!$cardMemory) {
//                        $cardMemory = new CardMemory();
//                        $cardMemory->size = $value;
//                        $cardMemory->save();
//                    }
//                    
//                    $specifications->card_memory_id = $cardMemory->id;
//                    break;
//                case ProductTableStructure::DEVICE_35_JACK:
//                    $specifications->jack_35 = $value;
//                    break;
//                case ProductTableStructure::DEVICE_BLUETOOTH:
//                    $specifications->bluetooth = $value;
//                    break;
//                case ProductTableStructure::DEVICE_USB_TYPE:
//                    $usbType = UsbType::findOne($value);
//                        
//                    if(!$usbType) {
//                        $usbType = new UsbType();
//                        $usbType->type = $value;
//                        $usbType->save();
//                    }
//
//                    $specifications->usb_type_id = $usbType->id;
//                    break;
//                case ProductTableStructure::DEVICE_USB_STANDARD:
//                    $usbStardard = UsbStandard::findOne($value);
//                    
//                    if(!$usbStardard) {
//                        $usbStardard = new UsbStandard();
//                        $usbStardard->standard = $value;
//                        $usbStardard->save();
//                    }
//
//                    $specifications->usb_standard_id = $usbStardard->id;
//                    break;
//                case ProductTableStructure::DEVICE_WIRELESS_CHARGE:
//                    $specifications->wireless_charge = $value;
//                    break;
//                case ProductTableStructure::DEVICE_FAST_CHARGE:
//                    $specifications->fast_charge = $value;
//                    break;
                case ProductTableStructure::BROWSE_NODE:
                    $browseNode = BrowseNodeRepository::findByValue($value);

//                    if(!$amazonProductType) {
//                        $amazonProductType = new AmazonProductType();
//                        $amazonProductType->type = $value;
//                        $amazonProductType->save();
//                    }
                        
                    $specifications->browse_node_id = $browseNode->id;
                    break;
                case ProductTableStructure::VARIATION_THEME:
                    $variationTheme = VariationThemeRepository::findByValue($value);

                    if(!$variationTheme) {
                        $variationTheme = new VariationTheme();
                        $variationTheme->title = $value;
                        $variationTheme->save();
                    }

                    $specifications->variation_theme_id = $variationTheme->id;
                    break;
                case ProductTableStructure::PRICE:
                    $specifications->price = PriceHelper::toInt($value);
                    break;
                case ProductTableStructure::IMAGE:
                    $specifications->image = $value;
                    break;
                case ProductTableStructure::DEVICE_TYPE:
                    if($specifications->deviceTypes) {
                        foreach ($specifications->deviceTypes as $deviceType) {
                            $specifications->unlink('deviceTypes', $deviceType);
                        }
                    }else{
                        $product->save();
                        $specifications->save();
                    }
                    
                    $selectedTypes = explode(',', $value);
                    $types = DeviceType::find()->where(["IN", 'type', $selectedTypes])->all();

                    if($types){
                        /** @var DeviceType $type */
                        foreach ($types as $type) {
                            $specifications->link('deviceTypes', $type);
                        }
                    }

                    break;
            }
        }
        
        if($product->id) {
            return ($product->save() && $specifications->save());
        }else{
            if($product->save()) {
                $specifications->product_id = $product->id;
                return $specifications->save();
            }else{
                \Yii::error($product->getErrors());
                return false;
            }
        }
        
    }
    
    public static function getSpecificationList($id)
    {
        $list = [];
        switch ($id) {
            case ProductTableStructure::NODE:
                $list = ProductRepository::getNodeAsArray();
                break;
            case ProductTableStructure::DEVICE_TYPE:
                $list = DeviceTypeRepository::getAllAsArray();
                break;
            case ProductTableStructure::TYPE:
                $list = ProductTypeRepository::getAllAsArray();
                break;
            case ProductTableStructure::MERCHANT:
                $list = MerchantRepository::getAllAsArray();
                break;
            case ProductTableStructure::BRAND:
                $list = ProductBrandRepository::getAllAsArray();
                break;
            case ProductTableStructure::MANUFACTURER:
                $list = ManufacturerRepository::getAllAsArray();
                break;
            case ProductTableStructure::UNIT_MEASURE:
                $list = MeasureUnitRepository::getAllAsArray();
                break;
            case ProductTableStructure::BARCODE_TYPE:
                $list = BarcodeTypeRepository::getAllAsArray();
                break;
            case ProductTableStructure::BROWSE_NODE:
                $list = BrowseNodeRepository::getAllAsArray();
                break;
            case ProductTableStructure::VARIATION_THEME:
                $list = VariationThemeRepository::getAllAsArray();
                break;
            case ProductTableStructure::PARENT_ID:
                $list = ProductRepository::getParentsAsArray();
                break;
        }
        
        return $list;
    }
    
    private function addSort($params, $type)
    {
        $uniqParam = $type == 'ASC' ? 1 : 2;
        
        foreach ($params as $param) {
            switch ($param) {
                case ProductTableStructure::DEVICE_TYPE:
                    $this->query
                        ->innerJoin('device_type dt' . $uniqParam, "dt{$uniqParam}.id = s.type_id")
                        ->addOrderBy("dt{$uniqParam}.type $type");
                    break;
                case ProductTableStructure::BRAND:
                    $this->query
                        ->innerJoin('device_brand db' . $uniqParam, "db{$uniqParam}.id = d.brand_id")
                        ->addOrderBy("db{$uniqParam}.name $type");
                    break;
                case ProductTableStructure::TITLE:
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
                case DeviceTableStructure::PRICE:
                    $this->query
                        ->addOrderBy("s.price $type");
                    break;
            }
        }
    }
}