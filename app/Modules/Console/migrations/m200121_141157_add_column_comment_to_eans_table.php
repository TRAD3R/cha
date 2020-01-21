<?php

use yii\db\Migration;

class m200121_141157_add_column_comment_to_eans_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%eans}}', 'comment', $this->string(255));
    }
    
    public function safeDown()
    {
        $this->dropColumn('{{%eans}}', 'comment');
    }
}