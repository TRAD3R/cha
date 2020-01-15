<?php


namespace App\Helpers;


use App\Models\BarcodeType;
use App\Models\DeviceType;
use App\Models\Manufacturer;
use App\Models\MeasureUnit;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductSpecification;
use App\Models\ProductType;
use App\Models\Swatch;
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
use App\Repositories\SwatchRepository;
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
        
        $individualParentid = Product::TYPE_INDIVIDUAL;
        $this->query
            ->andWhere("p.parent_id IS NULL OR p.parent_id = {$individualParentid}")
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
                    $type = ProductTypeRepository::findOneByValue($value);

                    if($type){
                        $specifications->type_id = $type->id;
                    }
                    break;
                case ProductTableStructure::MERCHANT:
                    $merchant = MerchantRepository::findOneByValue($value);

                    if(!$merchant){
                        $merchant = new Merchant();
                        $merchant->name = $value;
                        $merchant->save();
                    }

                    $specifications->merchant_id = $merchant->id;
                    break;
                case ProductTableStructure::MANUFACTURER:
                    $manufacturer = ManufacturerRepository::findOneByValue($value);

                    if(!$manufacturer){
                        $manufacturer = new Manufacturer();
                        $manufacturer->name = $value;
                        $manufacturer->save();
                    }
                    
                    $specifications->manufacturer_id = $manufacturer->id;
                    break;
                case ProductTableStructure::SKU:
                    $specifications->sku = $value;
                    break;
                case ProductTableStructure::BRAND:
                    $brand = ProductBrandRepository::findOneByValue($value);

                    if(!$brand){
                        $brand = new ProductBrand();
                        $brand->name = $value;
                        $brand->save();
                    }

                    $specifications->link('productBrand', $brand);
                    break;
                case ProductTableStructure::TITLE:
                    $product->name = $value;
                    break;
                case ProductTableStructure::DESCRIPTION:
                    $specifications->description = $value;
                    break;
                case ProductTableStructure::KEYWORDS:
                    $specifications->keywords = $value;
                    break;
                case ProductTableStructure::LENGTH:
                    $specifications->length = $value;
                    break;
                case ProductTableStructure::WIDTH:
                    $specifications->width = $value;
                    break;
                case ProductTableStructure::DEPTH:
                    $specifications->depth = $value;
                    break;
                case ProductTableStructure::SIZE:
                    $specifications->size = $value;
                    break;
                case ProductTableStructure::UNIT_MEASURE:
                    $measureUnit = MeasureUnitRepository::findOneByValue($value);
                    
                    if(!$measureUnit) {
                        $measureUnit = new MeasureUnit();
                        $measureUnit->type = $value;
                        $measureUnit->save();
                    }
                    
                    $specifications->link('measureUnit', $measureUnit);
                    break;
                case ProductTableStructure::PRICE:
                    $specifications->price = PriceHelper::toInt($value);
                    break;
                case ProductTableStructure::QUANTITY:
                    $specifications->quantity = $value;
                    break;
                case ProductTableStructure::BULLETPOINT_1:
                    $specifications->bulletpoint_1 = $value;
                    break;
                case ProductTableStructure::BULLETPOINT_2:
                    $specifications->bulletpoint_2 = $value;
                    break;
                case ProductTableStructure::BULLETPOINT_3:
                    $specifications->bulletpoint_3 = $value;
                    break;
                case ProductTableStructure::BULLETPOINT_4:
                    $specifications->bulletpoint_4 = $value;
                    break;
                case ProductTableStructure::BULLETPOINT_5:
                    $specifications->bulletpoint_5 = $value;
                    break;
                case ProductTableStructure::SWATCH_IMAGE:
                    $swatch = SwatchRepository::findOneByValue($value);

                    if($swatch){
                        $specifications->link('swatch', $swatch);
                    }

                    break;
                case ProductTableStructure::BARCODE:
                    $specifications->barcode = $value;
                    break;
                case ProductTableStructure::BARCODE_TYPE:
                    $barcode = BarcodeTypeRepository::findOneByValue($value);

                    if(!$barcode) {
                        $barcode = new BarcodeType();
                        $barcode->type = $value;
                        $barcode->save();
                    }
                    
                    $specifications->link("barcodeType", $barcode); 
                    break;
                case ProductTableStructure::BROWSE_NODE:
                    $browseNode = BrowseNodeRepository::findOneByValue($value);

                    if($browseNode){
                        $specifications->link("browseNode", $browseNode);
                    }

                    break;
                case ProductTableStructure::VARIATION_THEME:
                    $variationTheme = VariationThemeRepository::findOneByValue($value);

                    if(!$variationTheme) {
                        $variationTheme = new VariationTheme();
                        $variationTheme->title = $value;
                        $variationTheme->save();
                    }

                    $specifications->variation_theme_id = $variationTheme->id;
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
                        $specifications->link('product', $product);
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
        
        if($specifications->product_id) {
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
            case ProductTableStructure::SWATCH_IMAGE:
              $list = SwatchRepository::getAllAsArray();
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