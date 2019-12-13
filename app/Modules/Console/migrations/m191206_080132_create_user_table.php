<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m191206_080132_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(100)->unique(),
            'password_hash' => $this->string(100),
            'auth_key' => $this->string(100)->unique(),
            'date_created' => $this->dateTime(),
            'date_updated' => $this->dateTime(),
            'date_last_visit' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
