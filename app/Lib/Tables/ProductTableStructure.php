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
    const BULLETPOINT_1 = 19;
    const BULLETPOINT_2 = 20;
    const BULLETPOINT_3 = 21;
    const BULLETPOINT_4 = 22;
    const BULLETPOINT_5 = 23;
    const IMAGE_1 = 24;
    const IMAGE_2 = 25;
    const IMAGE_3 = 26;
    const IMAGE_4 = 27;
    const IMAGE_5 = 28;
    const IMAGE_6 = 29;
    const IMAGE_7 = 30;
    const IMAGE_8 = 31;
    const IMAGE_9 = 32;
    const SWATCH_IMAGE = 33;
    const BARCODE = 34;
    const BARCODE_TYPE = 35;
    const BROWSE_NODE = 36;
    const PRODUCT_TYPE = 37;
    const VARIATION_THEME = 38;
    
    const PRODUCT_GROUP_CUSTOM = 'custom';
    const PRODUCT_GROUP_MAINCHARACTERISTIC = 'mainCharacteristic';
    const PRODUCT_GROUP_PARAMS = 'params';
    const PRODUCT_GROUP_PRICE = 'price';
    const PRODUCT_GROUP_SEO = 'seo';
    const PRODUCT_GROUP_CONTENT = 'content';
    const PRODUCT_GROUP_AMAZON = 'amazon';

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
            self::BULLETPOINT_1 => Yii::t('front', 'BULLETPOINT', ['number' => 1]),
            self::BULLETPOINT_2 => Yii::t('front', 'BULLETPOINT', ['number' => 2]),
            self::BULLETPOINT_3 => Yii::t('front', 'BULLETPOINT', ['number' => 3]),
            self::BULLETPOINT_4 => Yii::t('front', 'BULLETPOINT', ['number' => 4]),
            self::BULLETPOINT_5 => Yii::t('front', 'BULLETPOINT', ['number' => 5]),
          ],
          self::PRODUCT_GROUP_CONTENT => [
            self::IMAGE_1 => Yii::t('front', 'IMAGE_NUM', ['number' => 1]),
            self::IMAGE_2 => Yii::t('front', 'IMAGE_NUM', ['number' => 2]),
            self::IMAGE_3 => Yii::t('front', 'IMAGE_NUM', ['number' => 3]),
            self::IMAGE_4 => Yii::t('front', 'IMAGE_NUM', ['number' => 4]),
            self::IMAGE_5 => Yii::t('front', 'IMAGE_NUM', ['number' => 5]),
            self::IMAGE_6 => Yii::t('front', 'IMAGE_NUM', ['number' => 6]),
            self::IMAGE_7 => Yii::t('front', 'IMAGE_NUM', ['number' => 7]),
            self::IMAGE_8 => Yii::t('front', 'IMAGE_NUM', ['number' => 8]),
            self::IMAGE_9 => Yii::t('front', 'IMAGE_NUM', ['number' => 9]),
            self::SWATCH_IMAGE => Yii::t('front', 'SWATCH_IMAGE'),
          ],
          self::PRODUCT_GROUP_AMAZON => [
            self::BARCODE => Yii::t('front', 'BARCODE'),
            self::BARCODE_TYPE => Yii::t('front', 'BARCODE_TYPE'),
            self::BROWSE_NODE => Yii::t('front', 'BROWSE_NODE'),
            self::PRODUCT_TYPE => Yii::t('front', 'PRODUCT_TYPE'),
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
            self::SKU,
            self::BRAND,
            self::MANUFACTURER,
            self::LENGTH,
            self::WIDTH,
            self::DEPTH,
            self::SIZE,
            self::UNIT_MEASURE,
            self::PRICE,
            self::QUANTITY,
            self::BARCODE,
            self::BARCODE_TYPE,
            self::BROWSE_NODE,
            self::PRODUCT_TYPE,
            self::VARIATION_THEME,
        ];
    }

}