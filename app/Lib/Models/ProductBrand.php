<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class ProductBrand
 * @package App\Models
 * @property int        $id             [integer(11)]
 * @property int        $date_created   [integer(11)]
 * @property int        $date_updated   [integer(11)]
 * @property string     $name           [varchar(50)]
 * @property string     $logo           [varchar(255)]
 * @property Product[]   $products
 */
class ProductBrand extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_brands';
    }
    
    public function behaviors()
    {
        return [
            Timestamp::class
        ];
    }
    
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['brand_id' => 'id']);
    }
}