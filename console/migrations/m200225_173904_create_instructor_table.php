<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%instructor}}`.
 */
class m200225_173904_create_instructor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%instructor}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull()->comment('ИД'),
            'fkUserId'      => $this->integer()->unsigned()->notNull()->comment('Ссылка на пользователя'),
            'name'          => $this->string()->notNull()->defaultValue('[Нет имени]')->comment('Имя'),
            'balance'       => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Остаток денежных средств на счете'),
            'avatar'        => $this->string()->defaultValue(null)->comment('Аватар'),
            'certificate'   => $this->string()->defaultValue(null)->comment('Сертификаты'),
            'language'      => $this->string()->defaultValue(null)->comment('Языки'),
            'phone'         => $this->string()->defaultValue(null)->comment('Телефон'),
            'www'           => $this->string()->defaultValue(null)->comment('Личная страница'),
            'profileFb'     => $this->string()->defaultValue(null)->comment('Профиль на фейсбуке'),
            'profileIg'     => $this->string()->defaultValue(null)->comment('Профиль на инстраграме'),
            'profileOk'     => $this->string()->defaultValue(null)->comment('Профиль на одноклассниках'),
            'profileSkype'  => $this->string()->defaultValue(null)->comment('Профиль на скайпе'),
            'profileTw'     => $this->string()->defaultValue(null)->comment('Профиль на твитере'),
            'profileViber'  => $this->string()->defaultValue(null)->comment('Профиль на вайбере'),
            'profileVk'     => $this->string()->defaultValue(null)->comment('Профиль на вконтакте'),
            'profileWs'     => $this->string()->defaultValue(null)->comment('Профиль на ватцапе'),
            'profileYt'     => $this->string()->defaultValue(null)->comment('Профиль на ютьюбе'),
            'profileTh'     => $this->string()->defaultValue(null)->comment('Профиль на thetahealing.com'),
            'email'         => $this->string()->defaultValue(null)->comment('Электронная почта'),
            'about'         => "LONGTEXT NULL COMMENT 'Обо мне'",
            'numPubSeminar' => $this->integer()->unsigned()->defaultValue(0)->comment('Количество опубликованных семинаров'),
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Инструкторы'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%instructor}}');
    }
}
