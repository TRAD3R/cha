<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manufacturers}}`.
 */
class m191221_080211_create_manufacturers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manufacturers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
        ]);
        $this->batchInsert('{{%manufacturers}}', ['id', 'name'], [
            [1,"Belkin"],
            [2,"D-Parts"],
            [3,"Assmann"],
            [4,"Fontastic"],
            [5,"Conceptronic"],
            [6,"Kingston"],
            [7,"Pedea"],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%manufacturers}}');
    }
}
