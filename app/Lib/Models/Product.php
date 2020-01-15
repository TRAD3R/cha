<?php


namespace App\Models;


use App\Behaviors\Timestamp;
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
 * @property ProductImage[]         $images
 * @property Product[]              $children
 */
class Product extends ActiveRecord
{
    const TYPE_INDIVIDUAL = -1;
    
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

    public function beforeDelete()
    {
        if(!parent::beforeDelete()) {
            return false;
        }

        $specifications = $this->specifications;

        return $specifications->delete();
    }

    public function getParent()
    {
        return $this->hasOne(Product::class, ['id' => 'parent_id']);
    }
    
    public function getSpecifications()
    {
        return $this->hasOne(ProductSpecification::class, ['product_id' => 'id']);
    }

    public function getImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }
    
    public function getChildren()
    {
        return self::find()
            ->where(['parent_id' => $this->id])
            ->orderBy('id ASC')
            ->all()
            ;
    }

}