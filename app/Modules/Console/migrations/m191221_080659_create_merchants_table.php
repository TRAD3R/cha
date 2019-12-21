<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%merchants}}`.
 */
class m191221_080659_create_merchants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%merchants}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%merchants}}');
    }
}
