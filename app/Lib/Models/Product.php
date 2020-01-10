<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class Product
 * @package App\Models
 * 
 * @property int                    $id                 [integer(11)]
 * @property int                    $date_created       [datetime]
 * @property int                    $date_updated       [datetime]
 * @property string                 $name               [varchar(255)]
 * @property int                    $parent_id          [integer(11)]
 * @property Product                $parent
 * @property ProductSpecification   $specifications
 * @property Buletpoint[]           $buletpoints
 * @property ProductImage[]         $images
 */
class Product extends ActiveRecord
{
    const TYPE_MICROUSB     = 1;
    const TYPE_USB_C        = 2;
    const TYPE_LIGHTNING    = 3;
    
    public static function tableName()
    {
        return 'products';
    }

    public function behaviors()
    {
        return [
            Timestamp::class
        ];
    }

    public function getParent()
    {
        return $this->hasOne(Product::class, ['id' => 'parent_id']);
    }
    
    public function getSpecifications()
    {
        return $this->hasOne(ProductSpecification::class, ['product_id' => 'id']);
    }

    public function getBuletpoints()
    {
        return $this->hasMany(Buletpoint::class, ['product_id' => 'id']);
    }

    public function getImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }

}