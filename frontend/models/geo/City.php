<?php

namespace frontend\models\geo;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id ИД
 * @property string $type Тип
 * @property string $name Наименование
 * @property string $genitive Родительный падеж - Кого Чего
 * @property string $prepositionalСase предложный падеж - О ком О чем
 * @property string $area Область, куда входит город
 * @property int $fkIdArea ИД области
 * @property string|null $region Район, куда входит город
 * @property int|null $people Количество населения
 * @property string|null $phoneCode Телефонный код города
 * @property int $phoneLen Длина телефонного кода города
 * @property string $latitude Географическая широта
 * @property string $longitude Географическая долгота
 * @property string|null $nameEnglish Наименование на английском языке
 * @property string $distanceBorderCity Расстояние от границы города (МКАД, КАД...)
 * @property int|null $count_flat Удалить
 * @property int $double Есть дубли наименования города
 * @property int $workCoord Признак, что координаты были введены вручную
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'genitive', 'prepositionalСase', 'area', 'fkIdArea', 'phoneLen', 'latitude', 'longitude', 'distanceBorderCity', 'double'], 'required'],
            [['type'], 'string'],
            [['fkIdArea', 'people', 'phoneLen', 'count_flat', 'double', 'workCoord'], 'integer'],
            [['name', 'genitive', 'prepositionalСase', 'region', 'nameEnglish'], 'string', 'max' => 64],
            [['area'], 'string', 'max' => 50],
            [['phoneCode'], 'string', 'max' => 32],
            [['latitude', 'longitude', 'distanceBorderCity'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'genitive' => 'Genitive',
            'prepositionalСase' => 'Prepositional Сase',
            'area' => 'Area',
            'fkIdArea' => 'Fk Id Area',
            'region' => 'Region',
            'people' => 'People',
            'phoneCode' => 'Phone Code',
            'phoneLen' => 'Phone Len',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'nameEnglish' => 'Name English',
            'distanceBorderCity' => 'Distance Border City',
            'count_flat' => 'Count Flat',
            'double' => 'Double',
            'workCoord' => 'Work Coord',
        ];
    }

    public function idByNameEnglish($nameEnglish)
    {
        $request =
            'SELECT '
                . 'id '
            . 'FROM '
                . '`city` '
            . 'WHERE '
                . 'nameEnglish=:nameEnglish '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':nameEnglish', $nameEnglish)
            ->queryScalar();
    }

}
