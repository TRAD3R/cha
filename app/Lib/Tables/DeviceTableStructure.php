<?php


namespace App\Tables;


use App\Tables\AbstractTS;
use Yii;

class DeviceTableStructure extends AbstractTS
{
    const DEVICE_DATE_CREATED = 1;
    const DEVICE_TYPE = 2;
    const DEVICE_BRAND = 3;
    const DEVICE_MODEL = 4;
    const DEVICE_LENGTH = 5;
    const DEVICE_WIDTH = 6;
    const DEVICE_DEPTH = 7;
    const DEVICE_SCREEN_SIZE = 8;
    const DEVICE_CARD_MEMORY = 9;
    const DEVICE_35_JACK = 10;
    const DEVICE_BLUETOOTH = 11;
    const DEVICE_USB_TYPE = 12;
    const DEVICE_USB_STANDARD = 13;
    const DEVICE_WIRELESS_CHARGE = 14;
    const DEVICE_FAST_CHARGE = 15;
    const DEVICE_REMOVABLE_BATTERY = 16;
    const DEVICE_PRICE = 17;
    const DEVICE_IMAGE = 18;
    const DEVICE_YEAR = 19;
    
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
            self::DEVICE_DATE_CREATED   => Yii::t('front', 'DATE_CREATED'),
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

}