<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seminar}}`.
 */
class m200225_172609_create_seminar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%seminar}}', [
            'id'                 => $this->primaryKey()->unsigned()->notNull()->comment('ИД'),
            'fkCityId'           => $this->integer()->unsigned()->notNull()->comment('ИД города'),
            'fkInstructorId1'    => $this->integer()->unsigned()->notNull()->comment('ИД инструктора 1'),
            'name'               => $this->string()->notNull()->comment('Наименование'),
            'startDate'          => $this->date()->notNull()->comment('Дата начала'),
            'durationDay'        => $this->integer()->unsigned()->notNull()->comment('Продолжительность, день'),
            'durationHour'       => $this->integer()->unsigned()->notNull()->comment('Продолжительность, часы'),
            'language'           => $this->string()->notNull()->comment('Язык преподавания'),
            'costDeposit'        => $this->integer()->unsigned()->notNull()->comment('Стоимость депозита'),
            'costSeminar'        => $this->integer()->unsigned()->notNull()->comment('Стоимость семинара'),
            'sertSeminar'        => $this->tinyInteger()->notNull()->comment('Сетифицированный семинар'),
            'authSeminar'        => $this->tinyInteger()->notNull()->comment('Авторский семинар'),
            //'type'               => "enum('сертифицированный','авторский') NOT NULL COMMENT 'Тип'",
            'publish'            => $this->boolean()->notNull()->defaultValue(false)->comment('Признак публикации'),
            'numberParticipants' => $this->integer()->unsigned()->notNull()->comment('Количество участников'),

            'fkInstructorId2'    => $this->integer()->unsigned()->defaultValue(0)->comment('ИД инструктора 2'),
            'fkInstructorId3'    => $this->integer()->unsigned()->defaultValue(0)->comment('ИД инструктора 3'),
            'description'        => "LONGTEXT NULL COMMENT 'Описание'",
            'schedule'           => "LONGTEXT NULL COMMENT 'Расписание'",
            'logo'               => $this->string()->defaultValue(null)->comment('Логотип'),
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Семинары'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%seminar}}');
    }
}
