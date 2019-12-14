<?php


namespace App\Helpers;


use App\Models\Device;
use App\Params;

class DeviceHelper
{
    const PER_PAGE = 100;
    
    public static function getDevices($limit, $offset, $sort = Params::SORT_TYPE_TITLE)
    {
        $query = Device::find()
            ->alias('d')
        ;
        
        switch ($sort) {
            case Params::SORT_TYPE_TITLE:
                $query
                    ->innerJoin('device_brand b', 'd.brand_id = b.id')
                    ->orderBy([
                        'b.name' => 'ASC', 
                        'd.title' => 'ASC'
                    ])
                ;
        }
        
        $query->limit($limit)
            ->offset($offset)
            ;
        
        return $query->all();
    }
}