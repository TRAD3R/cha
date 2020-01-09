<?php


namespace App\Tables;


use App\Tables\AbstractTS;
use Yii;

class ProductTableStructure extends AbstractTS
{
    const NODE = 101;
    const DEVICE_TYPE = 102;
    const TYPE = 103;
    const MERCHANT = 104;
    const SKU = 105;
    const MANUFACTURER = 106;
    const LENGTH = 107;
    const WIDTH = 108;
    const DEPTH = 109;
    const SIZE = 110;
    const UNIT_MEASURE = 111;
    const QUANTITY = 112;
    const DESCRIPTION = 113;
    const BULLETPOINT = 114;
    const SWATCH_IMAGE = 115;
    const BARCODE = 116;
    const BARCODE_TYPE = 117;
    const BROWSE_NODE = 118;
    const AMAZON_PRODUCT_TYPE = 119;
    const VARIATION_THEME = 120;
    const PARENT_ID = 121;
    
    const GROUP_SEO = 'seo';
    const GROUP_AMAZON = 'amazon';
    
    const BULLETPOINT_COUNT = 5;        // макс количество ключевых фраз
    const IMAGE_COUNT = 9;              // макс количество картинок

    public static function getTitles()
    {
        return [
          self::GROUP_CUSTOM => [
            self::ID => Yii::t('front', 'ID'),
          ],
          self::GROUP_MAINCHARACTERISTIC => [
            self::DATE_CREATED  => Yii::t('front', 'DATE_CREATED'),
            self::NODE          => Yii::t('front', 'NODE'),
            self::PARENT_ID     => Yii::t('front', 'PARENT'),
            self::DEVICE_TYPE   => Yii::t('front', 'DEVICE_TYPE'),
            self::TYPE          => Yii::t('front', 'TYPE'),
            self::MERCHANT      => Yii::t('front', 'MERCHANT'),
            self::SKU           => Yii::t('front', 'SKU'),
            self::BRAND         => Yii::t('front', 'BRAND'),
            self::MANUFACTURER  => Yii::t('front', 'MANUFACTURER'),
          ],
          self::GROUP_PARAMS => [
            self::LENGTH => Yii::t('front', 'LENGTH'),
            self::WIDTH => Yii::t('front', 'WIDTH'),
            self::DEPTH => Yii::t('front', 'DEPTH'),
            self::SIZE => Yii::t('front', 'SIZE'),
            self::UNIT_MEASURE => Yii::t('front', 'UNIT_MEASURE'),
          ],
          self::GROUP_PRICE => [
            self::PRICE => Yii::t('front', 'PRICE'),
            self::QUANTITY => Yii::t('front', 'QUANTITY'),
          ],
          self::GROUP_SEO => [
            self::TITLE => Yii::t('front', 'TITLE'),
            self::DESCRIPTION => Yii::t('front', 'DESCRIPTION'),
            self::BULLETPOINT => Yii::t('front', 'BULLETPOINT'),
          ],
          self::GROUP_CONTENT => [
            self::IMAGE => Yii::t('front', 'IMAGE'),
            self::SWATCH_IMAGE => Yii::t('front', 'SWATCH_IMAGE'),
          ],
          self::GROUP_AMAZON => [
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