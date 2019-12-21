<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%browse_nodes}}`.
 */
class m191221_085058_create_browse_nodes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%browse_nodes}}', [
            'id' => $this->primaryKey(),
            'node' => $this->string(20),
            'product_type' => $this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%browse_nodes}}');
    }
}
