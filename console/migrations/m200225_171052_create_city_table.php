<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m200225_171052_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey()->unsigned()->comment('ИД'),
            'type' => "enum('Большой город','Малый город','Городское поселение','Деревня','Микрорайон','Поселение','Посёлок','Посёлок городского типа','Село','Район','Станица','Муниципальный округ','Квартал','Территория','Жилой массив','Хутор','Аул') NOT NULL COMMENT 'Тип'",
            'name' => $this->string(64)->notNull()->comment('Наименование'),
            'genitive' => $this->string(64)->notNull()->comment('Родительный падеж - Кого Чего'),
            'prepositionalСase' => $this->string(64)->notNull()->comment('предложный падеж - О ком О чем'),
            'area' => $this->string(50)->notNull()->comment('Область, куда входит город'),
            'fkIdArea' => $this->integer()->unsigned()->notNull()->comment('ИД области'),
            'region' => $this->string(64)->null()->comment('Район, куда входит город'),
            'people' => $this->integer()->unsigned()->Null()->comment('Количество населения'),
            'phoneCode' => $this->string(32)->null()->comment('Телефонный код города'),
            'phoneLen' => $this->integer()->unsigned()->notNull()->comment('Длина телефонного кода города'),
            'latitude' => $this->string(11)->notNull()->comment('Географическая широта'),
            'longitude' => $this->string(11)->notNull()->comment('Географическая долгота'),
            'nameEnglish' => $this->string(64)->null()->comment('Наименование на английском языке'),
            'distanceBorderCity' => $this->string(11)->notNull()->comment('Расстояние от границы города (МКАД, КАД...)'),
            'count_flat' => $this->integer(5)->unsigned()->null()->comment('Удалить'),
            'double' => $this->tinyInteger()->unsigned()->notNull()->comment('Есть дубли наименования города'),
            'workCoord' => $this->tinyInteger()->defaultValue(0)->unsigned()->notNull()->comment('Признак, что координаты были введены вручную'),
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Города России'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}
