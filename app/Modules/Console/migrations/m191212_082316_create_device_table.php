<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device}}`.
 */
class m191212_082316_create_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%device}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(250)->notNull(),
            'brand_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%device}}');
    }
}
