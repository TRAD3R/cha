<?php


namespace App\Repositories;


use App\Models\Device;
use App\Models\DeviceBrand;

class DeviceRepository
{
    public static function getAllModelsAsArray()
    {
        return Device::getDb()->createCommand(
            "SELECT d.id, CONCAT(db.name, ' ', d.title) as title 
                    FROM " . Device::tableName() . " d 
                        INNER JOIN " . DeviceBrand::tableName() . " db on d.brand_id = db.id
                    ORDER BY title
                        "
        )->queryAll()
            ;
    }
}