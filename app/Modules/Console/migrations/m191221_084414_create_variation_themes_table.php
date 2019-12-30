<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%variation_themes}}`.
 */
class m191221_084414_create_variation_themes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%variation_themes}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%variation_themes}}');
    }
}
