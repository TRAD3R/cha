<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_types}}`.
 */
class m200109_071814_create_product_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_types}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(50)
        ]);
        
        $this->batchInsert('{{%product_types}}', ['id', 'type'], [
            [1, 'Lightning'],
            [2, 'MicroUSB'],
            [3, 'USB type-C'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_types}}');
    }
}
