<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%measure_unites}}`.
 */
class m191221_083646_create_measure_unites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%measure_unites}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%measure_unites}}');
    }
}
