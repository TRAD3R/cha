<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class Device
 * @package App\Models
 * 
 * @property int                    $id                 [integer(11)]
 * @property string                 $title              [varchar(250)]
 * @property int                    $brand_id           [integer(11)]
 * @property int                    $line_id            [integer(11)]
 * @property Line                   $line
 * @property DeviceBrand            $brand
 * @property DeviceSpecification    $specifications
 */
class Device extends ActiveRecord
{
    public static function tableName()
    {
        return 'devices';
    }
    
    public function beforeDelete()
    {
        if(!parent::beforeDelete()) {
            return false;
        }
        
        $specifications = $this->specifications;
        
        return $specifications->delete();
    }

    public function getBrand()
    {
        return $this->hasOne(DeviceBrand::class, ['id' => 'brand_id']);
    }

    public function getLine()
    {
        return $this->hasOne(Line::class, ['id' => 'line_id']);
    }
    
    public function getSpecifications()
    {
        return $this->hasOne(DeviceSpecification::class, ['device_id' => 'id']);
    }
}