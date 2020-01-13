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
            'title' => $this->string(30),
            'filename' => $this->string(30),
        ]);

        $this->batchInsert('{{%swatches}}', ['id', 'title', 'filename'], [
            [1,'Wild leather','wild-leather.swatch.jpg'],
            [2,'Red leather','red-leather.swatch.jpg'],
            [3,'Black leather','black-leather.swatch.jpg'],
            [4,'Brown leather','brown-leather.swatch.jpg'],
            [5,'Pink','pink.swatch.jpg'],
            [6,'Red','red.swatch.jpg'],
            [7,'Beige','beige.swatch.jpg'],
            [8,'Black','black.swatch.jpg'],
            [9,'Brown','brown.swatch.jpg'],
            [10,'Blue','blue.swatch.jpg'],
            [11,'White','white.swatch.jpg'],
            [12,'Silver','silver.swatch.jpg'],
            [13,'Gold','gold.swatch.jpg'],
            [14,'Rose-gold','rose-gold.swatch.jpg'],
            [15,'1 m','1-m.swatch.jpg'],
            [16,'1.8 m','1-8m.swatch.jpg'],
            [17,'3 m','3-m.swatch.jpg'],
            [18,'2 cool','2-cool.swatch.jpg'],
            [19,'4 cool','4-cool.swatch.jpg'],
            [20,'64gb','64gb.swatch.jpg'],
            [21,'128gb','128gb.swatch.jpg'],
            [22,'256gb','256gb.swatch.jpg'],
            [23,'512gb','512gb.swatch.jpg'],
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
