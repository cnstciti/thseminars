<?php

use yii\db\Migration;

/**
 * Class m200225_171420_delete_columns_city_table
 */
class m200225_171420_delete_columns_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%city}}', 'area');
        $this->dropColumn('{{%city}}', 'count_flat');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%city}}', 'area', 'varchar(255)');
        $this->addColumn('{{%city}}', 'count_flat', 'integer');
    }

}
