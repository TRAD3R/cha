<?php


namespace App\Tables;


use App\Tables\AbstractTS;
use Yii;

class ProductTableStructure extends AbstractTS
{
    const DATE_CREATED = 1;
    const NODE = 2;
    const DEVICE_TYPE = 4;
    const TYPE = 5;
    const MERCHANT = 6;
    const SKU = 7;
    const BRAND = 8;
    const MANUFACTURER = 9;
    const LENGTH = 10;
    const WIDTH = 11;
    const DEPTH = 12;
    const SIZE = 13;
    const UNIT_MEASURE = 14;
    const PRICE = 15;
    const QUANTITY = 16;
    const TITLE = 17;
    const DESCRIPTION = 18;
    const BULLETPOINT = 19;
    const IMAGE = 24;
    const SWATCH_IMAGE = 33;
    const BARCODE = 34;
    const BARCODE_TYPE = 35;
    const BROWSE_NODE = 36;
    const AMAZON_PRODUCT_TYPE = 37;
    const VARIATION_THEME = 38;
    
    const PRODUCT_GROUP_CUSTOM = 'custom';
    const PRODUCT_GROUP_MAINCHARACTERISTIC = 'mainCharacteristic';
    const PRODUCT_GROUP_PARAMS = 'params';
    const PRODUCT_GROUP_PRICE = 'price';
    const PRODUCT_GROUP_SEO = 'seo';
    const PRODUCT_GROUP_CONTENT = 'content';
    const PRODUCT_GROUP_AMAZON = 'amazon';
    
    const BULLETPOINT_COUNT = 5;        // макс количество ключевых фраз
    const IMAGE_COUNT = 9;              // макс количество картинок

    public static function getTitles()
    {
        return [
          self::PRODUCT_GROUP_CUSTOM => [
            0 => Yii::t('front', 'SECUENCE_NUMBER'),
          ],
          self::PRODUCT_GROUP_MAINCHARACTERISTIC => [
            self::DATE_CREATED  => Yii::t('front', 'DATE_CREATED'),
            self::NODE          => Yii::t('front', 'NODE'),
            self::DEVICE_TYPE   => Yii::t('front', 'DEVICE_TYPE'),
            self::TYPE          => Yii::t('front', 'TYPE'),
            self::MERCHANT      => Yii::t('front', 'MERCHANT'),
            self::SKU           => Yii::t('front', 'SKU'),
            self::BRAND         => Yii::t('front', 'BRAND'),
            self::MANUFACTURER  => Yii::t('front', 'MANUFACTURER'),
          ],
          self::PRODUCT_GROUP_PARAMS => [
            self::LENGTH => Yii::t('front', 'LENGTH'),
            self::WIDTH => Yii::t('front', 'WIDTH'),
            self::DEPTH => Yii::t('front', 'DEPTH'),
            self::SIZE => Yii::t('front', 'SIZE'),
            self::UNIT_MEASURE => Yii::t('front', 'UNIT_MEASURE'),
          ],
          self::PRODUCT_GROUP_PRICE => [
            self::PRICE => Yii::t('front', 'PRICE'),
            self::QUANTITY => Yii::t('front', 'QUANTITY'),
          ],
          self::PRODUCT_GROUP_SEO => [
            self::TITLE => Yii::t('front', 'TITLE'),
            self::DESCRIPTION => Yii::t('front', 'DESCRIPTION'),
            self::BULLETPOINT => Yii::t('front', 'BULLETPOINT'),
          ],
          self::PRODUCT_GROUP_CONTENT => [
            self::IMAGE => Yii::t('front', 'IMAGE'),
            self::SWATCH_IMAGE => Yii::t('front', 'SWATCH_IMAGE'),
          ],
          self::PRODUCT_GROUP_AMAZON => [
            self::BARCODE => Yii::t('front', 'BARCODE'),
            self::BARCODE_TYPE => Yii::t('front', 'BARCODE_TYPE'),
            self::BROWSE_NODE => Yii::t('front', 'BROWSE_NODE'),
            self::AMAZON_PRODUCT_TYPE => Yii::t('front', 'PRODUCT_TYPE'),
            self::VARIATION_THEME => Yii::t('front', 'VARIATION_THEME'),
          ],
        ];
    }

    /**
     * Столбцы, по которым можно сортировать
     * @return array
     */
    public static function getSortedColumns()
    {
        return [
            self::DATE_CREATED,
            self::BRAND,
            self::DEVICE_TYPE,
            self::TYPE,
            self::MERCHANT,
            self::BRAND,
            self::MANUFACTURER,
            self::PRICE,
            self::BARCODE,
            self::BARCODE_TYPE,
            self::BROWSE_NODE,
            self::AMAZON_PRODUCT_TYPE,
            self::VARIATION_THEME,
        ];
    }

}