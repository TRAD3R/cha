<?php


namespace App\Tables;


use App\Tables\AbstractTS;
use Yii;

class ProductTableStructure extends AbstractTS
{
    const DATE_CREATED = 1;
    const NODE = 2;
    const DEVICE_BRAND = 3;
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
    
    const DEVICE_GROUP_CUSTOM = 'custom';
    const DEVICE_GROUP_MAINCHARACTERISTIC = 'mainCharacteristic';
    const DEVICE_GROUP_PARAMS = 'params';
    const DEVICE_GROUP_INTERFACES = 'interfaces';
    const DEVICE_GROUP_PRICE = 'price';
    const DEVICE_GROUP_CONTENT = 'content';
    
    public static function getTitles()
    {
        return [
          self::DEVICE_GROUP_CUSTOM => [
            0 => Yii::t('front', 'SECUENCE_NUMBER'),
          ],
          self::DEVICE_GROUP_MAINCHARACTERISTIC => [
            self::PRODUCT_DATE_CREATED   => Yii::t('front', 'DATE_CREATED'),
            self::DEVICE_TYPE    => Yii::t('front', 'DEVICE_TYPE'),
            self::DEVICE_BRAND   => Yii::t('front', 'DEVICE_BRAND'),
            self::DEVICE_MODEL   => Yii::t('front', 'DEVICE_MODEL'),
            self::DEVICE_YEAR    => Yii::t('front', 'RELEASE_YEAR'),
          ],
          self::DEVICE_GROUP_PARAMS => [
            self::DEVICE_LENGTH => Yii::t('front', 'LENGTH'),
            self::DEVICE_WIDTH => Yii::t('front', 'WIDTH'),
            self::DEVICE_DEPTH => Yii::t('front', 'DEPTH'),
            self::DEVICE_SCREEN_SIZE => Yii::t('front', 'SCREEN_SIZE'),
          ],
          self::DEVICE_GROUP_INTERFACES => [
            self::DEVICE_CARD_MEMORY => Yii::t('front', 'CARD_MEMORY'),
            self::DEVICE_35_JACK => Yii::t('front', '35_JACK'),
            self::DEVICE_BLUETOOTH => Yii::t('front', 'BLUETOOTH'),
            self::DEVICE_USB_TYPE => Yii::t('front', 'USB_TYPE'),
            self::DEVICE_USB_STANDARD => Yii::t('front', 'USB_STANDARD'),
            self::DEVICE_WIRELESS_CHARGE => Yii::t('front', 'WIRELESS_CHARGE'),
            self::DEVICE_FAST_CHARGE => Yii::t('front', 'FAST_CHARGE'),
            self::DEVICE_REMOVABLE_BATTERY => Yii::t('front', 'REMOVABLE_BATTERY'),
          ],
          self::DEVICE_GROUP_PRICE => [
            self::DEVICE_PRICE => Yii::t('front', 'PRICE'),
          ],
          self::DEVICE_GROUP_CONTENT => [
            self::DEVICE_IMAGE => Yii::t('front', 'IMAGE'),
          ]
        ];
    }

    /**
     * Столбцы, по которым можно сортировать
     * @return array
     */
    public static function getSortedColumns()
    {
        return [
            self::PRODUCT_DATE_CREATED,
            self::DEVICE_TYPE,
            self::DEVICE_BRAND,
            self::DEVICE_MODEL,
            self::DEVICE_YEAR,
            self::DEVICE_LENGTH,
            self::DEVICE_WIDTH,
            self::DEVICE_DEPTH,
            self::DEVICE_SCREEN_SIZE,
            self::DEVICE_CARD_MEMORY,
            self::DEVICE_35_JACK,
            self::DEVICE_BLUETOOTH,
            self::DEVICE_USB_TYPE,
            self::DEVICE_USB_STANDARD,
            self::DEVICE_WIRELESS_CHARGE,
            self::DEVICE_FAST_CHARGE,
            self::DEVICE_REMOVABLE_BATTERY,
            self::DEVICE_PRICE,
        ];
    }

}