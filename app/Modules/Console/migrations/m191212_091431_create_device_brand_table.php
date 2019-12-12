<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device_brand}}`.
 */
class m191212_091431_create_device_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%device_brand}}', [
            'id' => $this->primaryKey(),
            'date_created' => $this->dateTime(),
            'date_updated' => $this->dateTime(),
            'name' => $this->string(50)->unique(),
            'logo' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%device_brand}}');
    }
}
