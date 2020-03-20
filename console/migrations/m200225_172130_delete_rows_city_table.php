<?php

use yii\db\Migration;

/**
 * Class m200225_172130_delete_rows_city_table
 */
class m200225_172130_delete_rows_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('{{%city}}', "type!='Большой город' AND type!='Малый город'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

}
