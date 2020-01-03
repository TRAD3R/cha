<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_images}}`.
 */
class m191221_075706_create_product_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_images}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'image' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_images}}');
    }
}
