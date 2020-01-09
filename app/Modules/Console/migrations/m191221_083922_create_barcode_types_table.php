<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%barcode_types}}`.
 */
class m191221_083922_create_barcode_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%barcode_types}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(20),
        ]);
        
        $this->batchInsert('{{%barcode_types}}', ['id', 'type'], [
            [1, 'EAN'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%barcode_types}}');
    }
}
