<?php


namespace App\Repositories;


use App\Models\Device;
use App\Models\DeviceBrand;
use App\Models\Product;
use App\Params;

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

    /**
     * @param Product[] $products
     */
    public static function getAllDevicesLinkToProduct($products, $selectedDeviceIds = [], $params = [], $offset = 0)
    {
        $query = Device::find()
            ->alias('d')
            ->innerJoin('device_specifications ds', 'd.id = ds.device_id')
//            ->where('1')
        ;
        /** Был ли уже добавлен в ограничение хоть один продукт */
        $isFiltered = false;
        
        if(count($products)){
            $query->innerJoin('usb_type ut', "ut.id = ds.usb_type_id")
            ;
        }
        
        foreach ($products as $product) {
            $productType = $product->specifications->type->alias;
            $deviceTypeIds = ProductRepository::getDeviceTypeIds($product);
            switch ($productType){
                case 'lightning':
                case 'microusb':
                case 'usb-c':
                    if(!$isFiltered){
                        $query
                            ->andWhere(["ut.alias" => $productType, "ds.type_id" => $deviceTypeIds])
                        ;
                        $isFiltered = true;
                    }else{
                        $query
                            ->orWhere(["ut.alias" => $productType, "ds.type_id" => $deviceTypeIds])
                        ;
                    }
                    
                    break;
            }
        }
        
        if($params[Params::BRANDS]){
            $query->andWhere(["IN", "d.brand_id", $params[Params::BRANDS]]);
        }

        if($params[Params::LISTING_SELECTED_DEVICE]){
            $query
                ->andWhere(['d.id' => $params[Params::LISTING_SELECTED_DEVICE]])
            ;
        }elseif($selectedDeviceIds){
            $query->andWhere(["IN", 'd.id', $selectedDeviceIds]);
        }

        $timeline = self::getTimeline($query);

        $from = strtotime($params[Params::SORT_DATE_FROM] ?: $timeline['from']);
        $to = strtotime($params[Params::SORT_DATE_TO] ?: $timeline['to']);

        $query
            ->andWhere('ds.date_created >= :datefrom', [':datefrom' =>  date("Y-m-d", $from)])
            ->andWhere('ds.date_created <= :dateto', ['dateto' => date("Y-m-d", $to)])
        ;
        
        $total = $query->count();

        $query
            ->addOrderBy('d.id ASC')
            ->offset($offset);

        if($params[Params::PER_PAGE]){
            $query
                ->limit($params[Params::PER_PAGE])
                ->offset($offset)
            ;
        }

        return [
            'items' => $query->all(),
            'total' => $total,
            Params::SORT_DATE_FROM  => $from,
            Params::SORT_DATE_TO  => $to,
        ];
    }

    /**
     * @param \yii\db\ActiveQuery $query
     * @return array
     */
    private static function getTimeline($query)
    {
        $res = $query->orderBy('ds.date_created ASC')->all();

        $from = 0;
        $to = 0;
        if($res){
            $from = $res[0]->specifications->date_created;
            $to = $res[count($res) - 1]->specifications->date_created;
        }

        return [
            'from'  => $from,
            'to'    => $to
        ];
    }
}