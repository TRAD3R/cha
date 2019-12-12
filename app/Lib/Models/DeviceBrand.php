<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class DeviceBrand
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property int        $date_created   [integer(11)]
 * @property int        $date_updated   [integer(11)]
 * @property string     $name           [varchar(50)]
 * @property string     $logo           [varchar(255)]
 * @property Device[]   $devices
 */
class DeviceBrand extends ActiveRecord
{
    public static function tableName()
    {
        return 'device_brands';
    }
    
    public function behaviors()
    {
        return [
            Timestamp::class
        ];
    }
    
    public function getDevices()
    {
        return $this->hasMany(Device::class, ['brand_id' => 'id']);
    }
}