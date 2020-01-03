<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lines}}`.
 */
class m200103_130923_create_lines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lines}}', [
            'id' => $this->primaryKey(),
            'date_created' => $this->dateTime(),
            'title' => $this->string(),
        ]);
        
        $this->batchInsert('', [], [
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lines}}');
    }
}
