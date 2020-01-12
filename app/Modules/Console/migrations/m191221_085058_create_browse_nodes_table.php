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
            'title' => $this->string(50),
            'product_type' => $this->string(50),
        ]);
        
        $this->batchInsert('{{%browse_nodes}}', ['id', 'product_type', 'node', 'title'], [
            [1, 'PhoneAccessory', '364935031', 'Handy Cover'],
            [2, 'ConsumerElectronics', '815150031', 'Tablet Cover'],
            [3, 'ComputerComponent', '1696198031', 'Laptop Tasche'],
            [4, 'kindleaccessories', '671887031', 'eReader Cover'],
            [5, 'PhoneAccessory', '364921031', 'Handy Cable'],
            [6, 'PhoneAccessory', '364921031', 'Tablet Cable'],
            [7, 'PhoneAccessory', '364921031', 'eReader Cable'],
            [8, 'PhoneAccessory', '364933031', 'Handy Laden'],
            [9, 'computercomponent', '815146031', 'Tablet Laden'],
            [10, 'kindleaccessories', '671888031', 'eReader Laden'],
            [11, 'PhoneAccessory', '364931031', 'Handy Kfz Laden'],
            [12, 'PhoneAccessory', '364931031', 'Tablet Kfz Laden'],
            [13, 'PhoneAccessory', '364931031', 'eReader Kfz Laden'],
            [14, 'PhoneAccessory', '1385091031', 'Handy Wireless Laden'],
            [15, 'ComputerComponent', '430112031', 'Laptop Cooling Pad'],
            [16, 'ComputerComponent', '1696197031', 'Laptop Rucksack'],
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
