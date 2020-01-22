<?php

use yii\db\Migration;

class m200121_122617_add_column_alias_to_product_types_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn("{{%product_types}}", "alias", $this->string(50)->comment("уникальное название для сопоставления при создании листинга"));
        $this->addColumn("{{%usb_type}}", "alias", $this->string(50)->comment("уникальное название для сопоставления при создании листинга"));
        
        $this->update("{{%product_types}}", ["alias" => 'lightning'], ['id' => 1]);
        $this->update("{{%product_types}}", ["alias" => 'microusb'], ['id' => 2]);
        $this->update("{{%product_types}}", ["alias" => 'usb-c'], ['id' => 3]);
        $this->update("{{%usb_type}}", ["alias" => 'lightning'], ['id' => 1]);
        $this->update("{{%usb_type}}", ["alias" => 'microusb'], ['id' => 2]);
        $this->update("{{%usb_type}}", ["alias" => 'usb-c'], ['id' => 3]);
    }
    
    public function safeDown()
    {
        $this->dropColumn("{{%product_types}}", "alias");
    }
}