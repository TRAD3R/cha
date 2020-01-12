<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class DeviceSpecification
 * @package App\Models
 * 
 * @property int            $device_id          [integer(11)]
 * @property int            $date_created       [datetime]
 * @property int            $date_updated       [datetime]
 * @property int            $type_id            [integer(11)]       тип (телефон, планшет и т.п.)
 * @property int            $year               [integer(4)]
 * @property int            $length             [integer(8)]        длина(высота) в мм
 * @property int            $width              [integer(8)]        ширина в мм
 * @property int            $depth              [integer(8)]        глубина(толщина) в мм
 * @property int            $screensize         [integer(8)]        диагональ в дюймах
 * @property int            $card_memory_id     [integer(11)]       макс объем карты памяти (null - отсутствует разъем)
 * @property boolean        $jack_35            [bit(1)]            наличие разъема для наушников
 * @property boolean        $bluetooth          [bit(1)]            наличие блютуз
 * @property int            $usb_type_id        [integer(11)]       тип USB
 * @property int            $usb_standard_id    [integer(11)]       стандарт USB
 * @property boolean        $wireless_charge    [bit(1)]            наличие функции беспроводной зарядки
 * @property boolean        $fast_charge        [bit(1)]            наличие функции быстрой зарядки
 * @property boolean        $removable_battery  [bit(1)]            наличие съемной батареи
 * @property int            $price              [int(7)]            цена
 * @property string         $image              [varchar(255)]      изображение гаджета
 * @property DeviceType     $type
 * @property CardMemory     $cardMemory
 * @property UsbType        $usbType
 * @property UsbStandard    $usbStandard
 */
class DeviceSpecification extends ActiveRecord
{
    public static function tableName()
    {
        return 'device_specifications';
    }

    public function behaviors()
    {
        return [
            Timestamp::class
        ];
    }
    
    public static function primaryKey()
    {
        return ['device_id'];
    }

    public function getDevice()
    {
        return $this->hasOne(Device::class, ['id' => 'device_id']);
    }

    public function getType()
    {
        return $this
            ->hasOne(DeviceType::class, ['id' => 'type_id'])
            ;
    }

    public function getCardMemory()
    {
        return $this
            ->hasOne(CardMemory::class, ['id' => 'card_memory_id'])
            ;
    }

    public function getUsbType()
    {
        return $this
            ->hasOne(UsbType::class, ['id' => 'usb_type_id'])
            ;
    }

    public function getUsbStandard()
    {
        return $this
            ->hasOne(UsbStandard::class, ['id' => 'usb_standard_id'])
            ;
    }
}