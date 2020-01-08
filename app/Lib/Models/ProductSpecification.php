<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class ProductSpecification
 * @package App\Models
 * @property int                $product_id             [integer(11)]
 * @property string             $type                   [varchar(20)]
 * @property int                $device_type_id         [integer(11)]
 * @property int                $type_id                [integer(11)]
 * @property int                $product_brand_id       [integer(11)]
 * @property int                $manufacturer_id        [integer(11)]
 * @property int                $length                 [integer(8)]        длина(высота) в мм
 * @property int                $width                  [integer(8)]        ширина в мм
 * @property int                $depth                  [integer(8)]        глубина(толщина) в мм
 * @property int                $merchant_id            [integer(11)]
 * @property string             $sku                    [varchar(50)]
 * @property int                $measure_unit_id        [integer(11)]
 * @property string             $description            [text]
 * @property string             $keywords               [varchar(255)]
 * @property string             $main_image             [varchar(255)]
 * @property string             $swatch_image           [varchar(255)]
 * @property string             $hersteller_barcode     [varchar(50)]
 * @property int                $barcode_type_id        [integer(11)]
 * @property int                $browse_node_id         [integer(11)]
 * @property int                $amazon_product_type_id [integer(11)]
 * @property int                $variation_theme_id     [integer(11)]
 * @property int                $price                  [integer(11)]
 * @property int                $quantity               [integer(11)]
 * @property Product            $product 
 * @property DeviceType         $deviceType 
 * @property ProductType        $productType 
 * @property ProductBrand       $productBrand 
 * @property Manufacturer       $manufacturer 
 * @property Merchant           $merchant 
 * @property MeasureUnit        $measureUnit 
 * @property BarcodeType        $barcodeType 
 * @property BrowseNode         $browseNode 
 * @property AmazonProductType  $amazonProductType 
 * @property VariationTheme     $variationTheme 
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

    public function getDeviceType()
    {
        return $this->hasOne(DeviceType::class, ['id' => 'device_type_id']);
    }

    public function getProductType()
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

    public function getAmazonProductType()
    {
        return $this->hasOne(AmazonProductType::class, ['id' => 'amazon_product_type_id']);
    }

    public function getVariationTheme()
    {
        return $this->hasOne(VariationTheme::class, ['id' => 'variation_theme_id']);
    }
}