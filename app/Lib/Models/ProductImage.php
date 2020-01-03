<?php


namespace App\Models;


use App\Behaviors\Timestamp;
use yii\db\ActiveRecord;

/**
 * Class ProductImage
 * @package App\Models
 * 
 * @property int                    $id                 [integer(11)]
 * @property string                 $image               [varchar(255)]
 * @property int                    $product_id          [integer(11)]
 * @property Product                $product
 */
class ProductImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'product_images';
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}