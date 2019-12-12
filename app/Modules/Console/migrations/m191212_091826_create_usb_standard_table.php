<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usb_standard}}`.
 */
class m191212_091826_create_usb_standard_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%usb_standard}}', [
            'id' => $this->primaryKey(),
            'standard' => $this->string(15)->unique(),
        ]);
        
        $this->batchInsert('{{%usb_standard}}', ['id', 'standard'], [
            ["1","2.0"],
            ["2","3.0"]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usb_standard}}');
    }
}
