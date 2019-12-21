<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_types}}`.
 */
class m191221_084104_create_product_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_types}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(50),
        ]);
        
        $this->batchInsert('{{%product_types}}', ['id', 'type'], [
            "1","ConsumerElectronics",
            "2","PhoneAccessory",
            "3","computercomponent",
            "4","kindleaccessories",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_types}}');
    }
}
