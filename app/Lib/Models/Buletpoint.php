<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class Buletpoint
 * @package App\Models
 * 
 * @property int                    $id                 [integer(11)]
 * @property string                 $buletpoint         [varchar(250)]
 * @property int                    $product_id         [integer(11)]
 * @property Product                $product
 */
class Buletpoint extends ActiveRecord
{
    public static function tableName()
    {
        return 'buletpoints';
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}