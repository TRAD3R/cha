<?php


namespace App\Helpers;


use App\Models\BarcodeType;
use App\Models\BrowseNode;
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

        
        
        $individualParentid = Product::TYPE_INDIVIDUAL;
        $this->query
            ->andWhere("p.parent_id IS NULL OR p.parent_id = {$individualParentid}");
        
        $total = $this->query->count();
        $this->query
            ->addOrderBy('p.id ASC')
            ->limit($params[Params::PER_PAGE])
            ->offset($offset)
            ;
        
        return [
            'items' => $this->query->all(),
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

                    $product->parent_id = $parent->id;
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

                    $specifications->product_brand_id = $brand->id;
                    break;
                case ProductTableStructure::TITLE:
                    $product->title = $value;
                    break;
                case ProductTableStructure::DESCRIPTION:
                    $specifications->description = $value;
                    break;
                case ProductTableStructure::KEYWORDS:
                    $specifications->keywords = $value;
                    break;
                case ProductTableStructure::VAR_TITLE:
                    $specifications->var_title = $value;
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
                    
                    $specifications->measure_unit_id = $measureUnit->id;
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
                        $specifications->swatch_id = $swatch->id;
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
                    
                    $specifications->barcode_type_id = $barcode->id; 
                    break;
                case ProductTableStructure::BROWSE_NODE:
                    $browseNode = BrowseNodeRepository::findOneByValue($value);

                    if($browseNode){
                        $specifications->browse_node_id = $browseNode->id;
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
                        $specifications->product_id = $product->id;
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
                case ProductTableStructure::DATE_CREATED:
                    $this->query
                        ->addOrderBy("s.date_created $type");
                    break;
                case ProductTableStructure::DEVICE_TYPE:
                    $this->query
                        ->innerJoin(DeviceType::tableName() . ' dt' . $uniqParam, "dt{$uniqParam}.id = s.type_id")
                        ->addOrderBy("dt{$uniqParam}.type $type");
                    break;
                case ProductTableStructure::BRAND:
                    $this->query
                        ->innerJoin(ProductBrand::tableName() . ' pb' . $uniqParam, "pb{$uniqParam}.id = s.brand_id")
                        ->addOrderBy("pb{$uniqParam}.name $type");
                    break;
                case ProductTableStructure::TYPE:
                    $this->query
                        ->innerJoin(ProductType::tableName() . ' pt' . $uniqParam, "pt{$uniqParam}.id = s.type_id")
                        ->addOrderBy("pt{$uniqParam}.type $type");
                    break;
                case ProductTableStructure::TITLE:
                    $this->query
                        ->addOrderBy("p.title $type");
                    break;
                case ProductTableStructure::MERCHANT:
                    $this->query
                        ->innerJoin(Merchant::tableName() . ' m' . $uniqParam, "m{$uniqParam}.id = s.merchant_id")
                        ->addOrderBy("m{$uniqParam}.name $type");
                    break;
                case ProductTableStructure::MANUFACTURER:
                    $this->query
                        ->innerJoin(Manufacturer::tableName() . ' mn' . $uniqParam, "mn{$uniqParam}.id = s.manufacturer_id")
                        ->addOrderBy("mn{$uniqParam}.name $type");
                    break;
                case ProductTableStructure::PRICE:
                    $this->query
                        ->addOrderBy("s.price $type");
                    break;
                case ProductTableStructure::BARCODE:
                    $this->query
                        ->addOrderBy("s.barcode $type");
                    break;
                case ProductTableStructure::BARCODE_TYPE:
                    $this->query
                        ->innerJoin(BarcodeType::tableName() . ' bt' . $uniqParam, "bt{$uniqParam}.id = s.barcode_type_id")
                        ->addOrderBy("bt{$uniqParam}.type $type");
                    break;
                case ProductTableStructure::BROWSE_NODE:
                    $this->query
                        ->innerJoin(BrowseNode::tableName() . ' bn' . $uniqParam, "bn{$uniqParam}.id = s.browsenode_id")
                        ->addOrderBy("bn{$uniqParam}.node $type");
                    break;
                case ProductTableStructure::AMAZON_PRODUCT_TYPE:
                    $this->query
                        ->innerJoin(BrowseNode::tableName() . ' bn1' . $uniqParam, "bn1{$uniqParam}.id = s.browsenode_id")
                        ->addOrderBy("bn1{$uniqParam}.product_type $type");
                    break;
                case ProductTableStructure::VARIATION_THEME:
                    $this->query
                        ->innerJoin(VariationTheme::tableName() . ' vt' . $uniqParam, "vt{$uniqParam}.id = s.variation_theme_id")
                        ->addOrderBy("vt{$uniqParam}.title $type");
                    break;
            }
        }
    }
}