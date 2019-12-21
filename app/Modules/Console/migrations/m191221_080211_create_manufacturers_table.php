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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%manufacturers}}');
    }
}
