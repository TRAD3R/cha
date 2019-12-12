<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device_type}}`.
 */
class m191212_091705_create_device_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%device_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(100)->unique(),
        ]);
        
        $this->batchInsert('{{%device_type}}', ['id', 'type'], [
            ["1","handy"],
            ["2","tablet"],
            ["3","ebook"],
            ["4","laptop"],
            ["5","other"]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%device_type}}');
    }
}
