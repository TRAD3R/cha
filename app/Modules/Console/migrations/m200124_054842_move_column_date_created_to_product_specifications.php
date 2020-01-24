<?php

use yii\db\Migration;

class m200124_054842_move_column_date_created_to_product_specifications extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('products', 'date_created');
        $this->dropColumn('products', 'date_updated');
        $this->addColumn('product_specifications', 'date_created',$this->dateTime()->after('product_id'));
        $this->addColumn('product_specifications', 'date_updated',$this->dateTime()->after('product_id'));
    }
    
    public function safeDown()
    {
        $this->dropColumn('product_specifications', 'date_created');
        $this->dropColumn('product_specifications', 'date_updated');
    }
}