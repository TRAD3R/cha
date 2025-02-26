<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_specifications}}`.
 */
class m191221_091706_create_product_specifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_specifications}}', [
            'product_id' => $this->primaryKey(),
            'type_id' => $this->integer(),
            'product_brand_id' => $this->integer(),
            'manufacturer_id' => $this->integer(),
            'length' => $this->float(1)->defaultValue(0),
            'width' => $this->float(1)->defaultValue(0),
            'depth' => $this->float(1)->defaultValue(0),
            'size' => $this->float(1)->defaultValue(0),
            'merchant_id' => $this->integer(),
            'sku' => $this->string(50),
            'measure_unit_id' => $this->integer(),
            'description' => $this->text(),
            'keywords' => $this->string(255),
            'var_title' => $this->string(50),
            'bulletpoint_1' => $this->text(),
            'bulletpoint_2' => $this->text(),
            'bulletpoint_3' => $this->text(),
            'bulletpoint_4' => $this->text(),
            'bulletpoint_5' => $this->text(),
            'swatch_id' => $this->integer(),
            'barcode' => $this->string(255),
            'barcode_type_id' => $this->integer(),
            'browse_node_id' => $this->integer(),
            'variation_theme_id' => $this->integer(),
            'price' => $this->integer(),
            'quantity' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_specifications}}');
    }
}
