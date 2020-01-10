<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m191221_072514_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'date_created' => $this->dateTime(),
            'date_updated' => $this->dateTime(),
            'name' => $this->string(255),
            'parent_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
