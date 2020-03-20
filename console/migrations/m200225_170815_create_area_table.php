<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%area}}`.
 */
class m200225_170815_create_area_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%area}}', [
            'id'          => $this->primaryKey()->unsigned()->comment('ИД'),
            'name'        => $this->string(64)->notNull()->comment('Наименование'),
            'genitive'    => $this->string(64)->notNull()->comment('Родительный падеж - Кого Чего'),
            'nameEnglish' => $this->string(32)->notNull()->comment('Наименование на английском языке'),
            'beforeName'  => $this->string(24)->notNull()->comment('Префикс наименования'),
            'afterName'   => $this->string(24)->notNull()->comment('Постфикс наименования'),
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Области России'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%area}}');
    }
}
