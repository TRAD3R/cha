<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usb_type}}`.
 */
class m191212_091958_create_usb_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%usb_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(15)->unique(),
        ]);
        
        $this->batchInsert('{{%usb_type}}', ['id', 'type'], [
            ["1","Lightning"],
            ["2","MicroUSB"],
            ["3","USB-C"]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usb_type}}');
    }
}
