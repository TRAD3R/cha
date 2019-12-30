<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_brands}}`.
 */
class m191221_065614_create_product_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_brands}}', [
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
        $this->dropTable('{{%product_brands}}');
    }
}
