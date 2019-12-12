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
            'size' => $this->string(15)->unique(),
        ]);
        
        $this->batchInsert('{{%card_memory}}', ['id', 'size'], [
            ["3","128Gb"],
            ["6","1Tb"],
            ["4","256Gb"],
            ["7","2Tb"],
            ["1","32Gb"],
            ["5","512Gb"],
            ["2","64Gb"]
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
