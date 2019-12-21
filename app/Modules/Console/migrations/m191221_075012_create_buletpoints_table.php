<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%buletpoints}}`.
 */
class m191221_075012_create_buletpoints_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%buletpoints}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'buletpoint' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%buletpoints}}');
    }
}
