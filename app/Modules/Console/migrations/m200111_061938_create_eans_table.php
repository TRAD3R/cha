<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%eans}}`.
 */
class m200111_061938_create_eans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%eans}}', [
            'id' => $this->primaryKey(),
            'date_created' => $this->dateTime(),
            'date_updated' => $this->dateTime(),
            'ean' => $this->string(50),
            'is_used' => $this->boolean()->defaultValue(false),
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%eans}}');
    }
}
