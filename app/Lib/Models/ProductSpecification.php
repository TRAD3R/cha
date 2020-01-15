<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class ProductSpecification
 * @package App\Models
 * @property int                $product_id             [integer(11)]
 * @property int                $type_id                [integer(11)]
 * @property int                $product_brand_id       [integer(11)]
 * @property int                $manufacturer_id        [integer(11)]
 * @property int                $length                 [integer(8)]        длина(высота) в мм
 * @property int                $width                  [integer(8)]        ширина в мм
 * @property int                $depth                  [integer(8)]        глубина(толщина) в мм
 * @property int                $size                   [integer(8)]        размер в мм
 * @property int                $merchant_id            [integer(11)]
 * @property string             $sku                    [varchar(50)]
 * @property int                $measure_unit_id        [integer(11)]
 * @property string             $description            [text]
 * @property string             $keywords               [varchar(255)]
 * @property string             $var_title              [varchar(50)]
 * @property string             $bulletpoint_1          [text]
 * @property string             $bulletpoint_2          [text]
 * @property string             $bulletpoint_3          [text]
 * @property string             $bulletpoint_4          [text]
 * @property string             $bulletpoint_5          [text]
 * @property int                $swatch_id              [integer(11)]
 * @property string             $barcode                [varchar(50)]
 * @property int                $barcode_type_id        [integer(11)]
 * @property int                $browse_node_id         [integer(11)]
 * @property int                $variation_theme_id     [integer(11)]
 * @property int                $price                  [integer(11)]
 * @property int                $quantity               [integer(11)]
 * @property Product            $product 
 * @property DeviceType[]       $deviceTypes 
 * @property ProductType        $type 
 * @property ProductBrand       $productBrand 
 * @property Manufacturer       $manufacturer 
 * @property Merchant           $merchant 
 * @property MeasureUnit        $measureUnit 
 * @property BarcodeType        $barcodeType 
 * @property BrowseNode         $browseNode 
 * @property VariationTheme     $variationTheme 
 * @property Swatch             $swatch
 */
class ProductSpecification extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_specifications';
    }
    
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getDeviceTypes()
    {
        return $this->hasMany(DeviceType::class, ['id' => 'device_type_id'])
            ->viaTable(ProductDeviceType::tableName(), ['product_id' => 'product_id'])
            ;
    }

    public function getType()
    {
        return $this->hasOne(ProductType::class, ['id' => 'type_id']);
    }

    public function getProductBrand()
    {
        return $this->hasOne(ProductBrand::class, ['id' => 'product_brand_id']);
    }

    public function getManufacturer()
    {
        return $this->hasOne(Manufacturer::class, ['id' => 'manufacturer_id']);
    }

    public function getMerchant()
    {
        return $this->hasOne(Merchant::class, ['id' => 'merchant_id']);
    }

    public function getMeasureUnit()
    {
        return $this->hasOne(MeasureUnit::class, ['id' => 'measure_unit_id']);
    }

    public function getBarcodeType()
    {
        return $this->hasOne(BarcodeType::class, ['id' => 'barcode_type_id']);
    }

    public function getBrowseNode()
    {
        return $this->hasOne(BrowseNode::class, ['id' => 'browse_node_id']);
    }

    public function getVariationTheme()
    {
        return $this->hasOne(VariationTheme::class, ['id' => 'variation_theme_id']);
    }

    public function getSwatch()
    {
      return $this->hasOne(Swatch::class, ['id' => 'swatch_id']);
    }
}