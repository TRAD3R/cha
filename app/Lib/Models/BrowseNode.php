<?php


namespace App\Models;


use yii\db\ActiveRecord;

/**
 * Class BrowseNode
 * @package App\Models
 * 
 * @property int                    $id             [integer(11)]
 * @property string                 $node           [varchar(20)]
 * @property string                 $product_type   [varchar(50)]
 * @property string                 $title          [varchar(50)]
 */
class BrowseNode extends ActiveRecord
{
    public static function tableName()
    {
        return 'browse_nodes';
    }
}