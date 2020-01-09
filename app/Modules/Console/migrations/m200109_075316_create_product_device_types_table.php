<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_device_types}}`.
 */
class m200109_075316_create_product_device_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_device_types}}', [
            'device_type_id' => $this->integer(),
            'product_id' => $this->integer(),
        ]);
        
        $this->createIndex(
            'product_device_type_index', 
            '{{%product_device_types}}', 
            ['device_type_id', 'product_id'],
            true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_device_types}}');
    }
}
