<?php


namespace App\Tables;


use App\Tables\AbstractTS;
use Yii;

class DeviceTableStructure extends AbstractTS
{
    const DEVICE_TYPE = 51;
    const DEVICE_LENGTH = 52;
    const DEVICE_WIDTH = 53;
    const DEVICE_DEPTH = 54;
    const DEVICE_SCREEN_SIZE = 55;
    const DEVICE_CARD_MEMORY = 56;
    const DEVICE_35_JACK = 57;
    const DEVICE_BLUETOOTH = 58;
    const DEVICE_USB_TYPE = 59;
    const DEVICE_USB_STANDARD = 60;
    const DEVICE_WIRELESS_CHARGE = 61;
    const DEVICE_FAST_CHARGE = 62;
    const DEVICE_REMOVABLE_BATTERY = 63;
    const DEVICE_YEAR = 64;
    const DEVICE_LINE = 65;

    const GROUP_INTERFACES = 'interfaces';

    public static function getTitles()
    {
        return [
          self::GROUP_CUSTOM => [
            0 => Yii::t('front', 'SECUENCE_NUMBER'),
          ],
          self::GROUP_MAINCHARACTERISTIC => [
            self::DATE_CREATED   => Yii::t('front', 'DATE_CREATED'),
            self::IMAGE => Yii::t('front', 'IMAGE'),
            self::DEVICE_TYPE    => Yii::t('front', 'DEVICE_TYPE'),
            self::BRAND   => Yii::t('front', 'BRAND'),
            self::TITLE   => Yii::t('front', 'DEVICE_MODEL'),
            self::DEVICE_LINE   => Yii::t('front', 'LINE'),
            self::DEVICE_YEAR    => Yii::t('front', 'RELEASE_YEAR'),
          ],
          self::GROUP_PARAMS => [
            self::DEVICE_LENGTH => Yii::t('front', 'LENGTH'),
            self::DEVICE_WIDTH => Yii::t('front', 'WIDTH'),
            self::DEVICE_DEPTH => Yii::t('front', 'DEPTH'),
            self::DEVICE_SCREEN_SIZE => Yii::t('front', 'SCREEN_SIZE'),
          ],
          self::GROUP_INTERFACES => [
            self::DEVICE_CARD_MEMORY => Yii::t('front', 'CARD_MEMORY'),
            self::DEVICE_35_JACK => Yii::t('front', '35_JACK'),
            self::DEVICE_BLUETOOTH => Yii::t('front', 'BLUETOOTH'),
            self::DEVICE_USB_TYPE => Yii::t('front', 'USB_TYPE'),
            self::DEVICE_USB_STANDARD => Yii::t('front', 'USB_STANDARD'),
            self::DEVICE_WIRELESS_CHARGE => Yii::t('front', 'WIRELESS_CHARGE'),
            self::DEVICE_FAST_CHARGE => Yii::t('front', 'FAST_CHARGE'),
            self::DEVICE_REMOVABLE_BATTERY => Yii::t('front', 'REMOVABLE_BATTERY'),
          ],
          self::GROUP_PRICE => [
            self::PRICE => Yii::t('front', 'PRICE'),
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
            self::DEVICE_TYPE,
            self::BRAND,
            self::TITLE,
            self::DEVICE_LINE,
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
            self::PRICE,
        ];
    }

}