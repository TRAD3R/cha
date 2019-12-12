<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device_specifications}}`.
 */
class m191212_092059_create_device_specifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%device_specifications}}', [
            'id' => $this->primaryKey(),
            'date_updated' => $this->dateTime(),
            'type_id' => $this->integer()->notNull(),
            'year' => $this->integer(4)->notNull(),
            'length' => $this->integer(8),
            'width' => $this->integer(8),
            'depth' => $this->integer(8),
            'card_memory_id' => $this->integer(),
            'jack_35' => $this->boolean(),
            'bluetooth' => $this->boolean(),
            'usb_type_id' => $this->integer(),
            'usb_standard_id' => $this->integer(),
            'wireless_charge' => $this->boolean(),
            'fast_charge' => $this->boolean(),
            'removable_battery' => $this->boolean(),
            'price' => $this->integer(7),
            'quantity' => $this->integer(5),
            'image' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%device_specifications}}');
    }
}
