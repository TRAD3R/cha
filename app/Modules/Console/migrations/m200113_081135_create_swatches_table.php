<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%swatches}}`.
 */
class m200113_081135_create_swatches_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%swatches}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30),
        ]);

        $this->batchInsert('{{%swatches}}', ['id', 'name'], [
          [1, 'wild-leather.swatch.jpg'],
          [2, 'red-leather.swatch.jpg'],
          [3, 'black-leather.swatch.jpg'],
          [4, 'brown-leather.swatch.jpg'],
          [5, 'pink.swatch.jpg'],
          [6, 'red.swatch.jpg'],
          [7, 'beige.swatch.jpg'],
          [8, 'black.swatch.jpg'],
          [9, 'brown.swatch.jpg'],
          [10, 'blue.swatch.jpg'],
          [11, 'white.swatch.jpg'],
          [12, 'silver.swatch.jpg'],
          [13, 'gold.swatch.jpg'],
          [14, 'rose-gold.swatch.jpg'],
          [15, '1-m.swatch.jpg'],
          [16, '1-8m.swatch.jpg'],
          [17, '3-m.swatch.jpg'],
          [18, '2-cool.swatch.jpg'],
          [19, '4-cool.swatch.jpg'],
          [20, '64gb.swatch.jpg'],
          [21, '128gb.swatch.jpg'],
          [22, '256gb.swatch.jpg'],
          [23, '512gb.swatch.jpg'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%swatches}}');
    }
}
