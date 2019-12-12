<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card_memory}}`.
 */
class m191212_081945_create_card_memory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card_memory}}', [
            'id' => $this->primaryKey(),
            'size' => $this->string(15),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%card_memory}}');
    }
}
