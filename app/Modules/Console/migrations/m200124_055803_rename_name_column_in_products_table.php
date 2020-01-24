<?php

use yii\db\Migration;

class m200124_055803_rename_name_column_in_products_table extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('products', 'name', 'title');
    }
    
    public function safeDown()
    {
        $this->renameColumn('products', 'title', 'name');

    }
}