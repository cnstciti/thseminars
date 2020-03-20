<?php

namespace frontend\models\seminar;

use Yii;
use yii\db\ActiveRecord;
//use frontend\models\instructor\Instructor;
//use frontend\models\geo\City;

/**
 * This is the model class for table "seminar".
 *
 * @property int $id ИД
 * @property int $fkCityId ИД города
 * @property int $fkInsructorId1 ИД инструктора 1
 * @property int $fkInsructorId2 ИД инструктора 2
 * @property int $fkInsructorId3 ИД инструктора 3
 * @property string $name Наименование
 * @property string $startDate Дата начала
 * @property int $durationDay Продолжительность, день
 * @property string|null $language Языки
 * @property int $costDeposit Стоимость депозита
 * @property int $costSeminar Стоимость семинара
 * @property string $description Описание
 * @property string $schedule Расписание
 * @property int $durationHour Продолжительность, час
 * @property int $numberParticipants Количество участников
 * @property int $sertSeminar Сертифицированный семинар
 * @property int $authSeminar Авторский семинар
 */

class Seminar extends ActiveRecord
{
    /*
    const RUS_SETR = 'сертифицированный';
    const EN_SETR = 'certified';
    const RUS_AUTHOR = 'авторский';
    const EN_AUTHOR = 'author';
*/
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seminar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'fkCityId',
                    'fkInstructorId1',
                    'startDate',
                    'durationDay',
                    'durationHour',
                    'costDeposit',
                    'costSeminar',
                    'description',
                    'language',
                    'numberParticipants',
                ],
                'required'
            ],
            [
                [
                    'fkInstructorId2',
                    'fkInstructorId3',
                    'schedule',
                    'sertSeminar',
                    'authSeminar',
                ],
                'safe'
            ],
            [
                [
                    'name',
                    'description',
                    'schedule',
                ],
                'trim'
            ],
            [
                [
                    'fkCityId',
                    'fkInstructorId1',
                    'fkInstructorId2',
                    'fkInstructorId3',
                ],
                'integer'
            ],
            [
                [
                    'description',
                    'schedule'
                ],
                'string'
            ],
            ['durationDay', 'integer', 'min' => 1, 'max' => 30],
            ['durationHour', 'integer', 'min' => 1, 'max' => 200],
            ['numberParticipants', 'integer', 'min' => 1, 'max' => 500],
            ['costDeposit', 'integer', 'min' => 0],
            ['costSeminar', 'integer', 'min' => 0],
            ['logo', 'image', 'extensions' => 'png, jpeg, jpg, gif',
                'minWidth'  => 200,
                'maxWidth'  => 300,
                'minHeight' => 100,
                'maxHeight' => 200,
                'maxSize'   => 1024*512, // размер файла должен быть меньше 500Кб
            ],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
//            'id' => 'ID',
            'fkCityId' => 'Город',
//            'fkInstructorId1' => 'Fk Insructor Id1',
            'fkInstructorId2' => 'Второй инструктор',
            'fkInstructorId3' => 'Третий инструктор',
            'name' => 'Наименование',
            'startDate' => 'Дата начала',
            'durationDay' => 'Продолжительность, в днях',
            'durationHour' => 'Продолжительность, в часах',
            'language' => 'Язык преподавания',
            'costDeposit' => 'Стоимость депозита',
            'costSeminar' => 'Стоимость семинара',
            'description' => 'Описание',
//            'type' => 'Тип',
            'schedule' => 'Расписание',
            'numberParticipants' => 'Количество участников',
            'logo' => 'Логотип',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->sertSeminar) {
                // если до этого был выбран авторский семинар и у него был логотип,
                // то удаляем старый лого
                if ($this->oldAttributes['authSeminar'] && $this->oldAttributes['logo']) {
                    unlink(Yii::getAlias('@logoAuthWWW') . '/' . $this->oldAttributes['logo']);
                }
            }
            if ($this->authSeminar) {
                if (!$insert && !$this->logo) {
                    if ($this->oldAttributes['sertSeminar']) {
                        $this->logo = '';
                    } else {
                        $this->logo = $this->oldAttributes['logo'];
                    }
                }
                // удаляем старый лого, если подгружен новый
                if ($this->oldAttributes['logo'] && $this->logo != $this->oldAttributes['logo']) {
                    if (!$this->oldAttributes['sertSeminar']) {
                        unlink(Yii::getAlias('@logoAuthWWW') . '/' . $this->oldAttributes['logo']);
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function allByUserId($userId)
    {
        $request =
            'SELECT '
                . 's.name '
                . ', DATE_FORMAT(s.startDate, "%d.%m.%Y") startDate '
                . ', s.durationDay '
                . ', s.durationHour '
                . ', s.language '
                . ', s.costDeposit '
                . ', s.costSeminar '
                . ', s.description '
                . ', s.sertSeminar '
                . ', s.authSeminar '
                . ', s.id '
                . ', s.publish '
                . ', s.numberParticipants '
                . ', c.name nameCity '
            . 'FROM '
                . '`seminar` s '
                . ', `city` c '
//                . ', `instructor` i '
            . 'WHERE '
                . 's.fkCityId=c.id '
                . 'AND s.fkInstructorId1=:userId '
//                . 'AND s.fkInstructorId1=i.id '
//                . 'AND i.fkUserId=:userId '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':userId', $userId)
            ->queryAll();
    }

    public function oneById($id)
    {
        $request =
            'SELECT '
                . 's.name '
                . ', DATE_FORMAT(s.startDate, "%d.%m.%Y") startDate '
                . ', s.durationDay '
                . ', s.durationHour '
                . ', s.language '
                . ', s.costDeposit '
                . ', s.costSeminar '
                . ', s.description '
                . ', s.schedule '
                . ', s.sertSeminar '
                . ', s.authSeminar '
                . ', s.id '
                . ', s.fkInstructorId1 '
                . ', s.fkInstructorId2 '
                . ', s.fkInstructorId3 '
                . ', s.logo '
                . ', s.numberParticipants '
                . ', c.name cityName '
            . 'FROM '
                . '`seminar` s '
                . ', `city` c '
            . 'WHERE '
                . 's.fkCityId=c.id '
                . 'AND s.id=:id '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':id', $id)
            ->queryOne();
    }

    public function isExist($seminarId, $userId)
    {
        $request =
            'SELECT '
                . 'count(s.id) '
            . 'FROM '
                . '`seminar` s '
//                . ', `instructor` i '
            . 'WHERE '
                . 's.fkInstructorId1=:userId '
//                . 's.fkInstructorId1=i.id '
//                . 'AND i.fkUserId=:userId '
                . 'AND s.id=:seminarId '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':userId', $userId)
            ->bindValue(':seminarId', $seminarId)
            ->queryScalar();
    }

    public function isExistById($seminarId)
    {
        $request =
            'SELECT '
                . 'count(id) '
            . 'FROM '
                . '`seminar` '
            . 'WHERE '
                . 'id=:seminarId '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':seminarId', $seminarId)
            ->queryScalar();
    }

    public function countActive($cityId, $type, $dateFrom, $dateTo)
    {
        $request =
            'SELECT '
                . 'count(id) '
            . 'FROM '
                . '`seminar` '
            . 'WHERE '
                . 'publish=1 '
                . 'AND startDate>=now() '
        ;

        if ($cityId) {
            $request .= 'AND fkCityId=:cityId ';
        }
        switch ($type) {
            case 'sert':
                $request .= 'AND sertSeminar=1 ';
                break;
            case 'auth':
                $request .= 'AND authSeminar=1 ';
                break;
            case 'free':
                $request .= 'AND (costDeposit+costSeminar)=0 ';
                break;
        }
        if ($dateFrom) {
            $request .= "AND startDate>=STR_TO_DATE('" . $dateFrom . "', '%Y-%m-%d') ";
        }
        if ($dateTo) {
            $request .= "AND startDate<=STR_TO_DATE('" . $dateTo . "', '%Y-%m-%d') ";
        }

        $command = Yii::$app->db->createCommand($request);
        if ($cityId) {
            $command->bindValue(':cityId', $cityId);
        }
        return $command->queryScalar();
    }

    public function activeCities()
    {
        $request =
            'SELECT '
                . 'count(c.id) num '
                . ', c.name '
                . ', c.nameEnglish '
            . 'FROM '
                . '`seminar` s '
                . ', `city` c '
            . 'WHERE '
                . 's.fkCityId=c.id '
                . 'AND s.publish=1 '
                . 'AND s.startDate>=now() '
            . 'GROUP BY '
                . 'c.id '
        ;
        return Yii::$app->db->createCommand($request)
            ->queryAll();
    }

    public function activeTypes()
    {
        $request =
            'SELECT '
                . 'sum(sert) sert '
                . ', sum(auth) auth '
                . ', sum(free) free '
            . 'FROM ( '
                . 'SELECT ' 
                    . 'count(id) sert '
                    . ', 0 auth '
                    . ', 0 free '
                . 'FROM  '
                    . '`seminar` ' 
                . 'WHERE '
                    . 'publish=1 '
                    . 'AND startDate>=now() '
                    . 'AND sertSeminar=1 '
                . 'UNION '
                . 'SELECT '
                    . '0 sert '
                    . ', count(id) auth '
                    . ', 0 free '
                . 'FROM '
                    . '`seminar` ' 
                . 'WHERE '
                    . 'publish=1 '
                    . 'AND startDate>=now() '
                    . 'AND authSeminar=1 '
                . 'UNION '
                . 'SELECT '
                    . '0 sert '
                    . ', 0 auth '
                    . ', count(id) free '
                . 'FROM '
                    . '`seminar` ' 
                . 'WHERE '
                    . 'publish=1 '
                    . 'AND startDate>=now() '
                    . 'AND (costDeposit+costSeminar)=0 '
            . ') u '
        ;
        return Yii::$app->db->createCommand($request)
            ->queryAll();
    }

    public function active($cityId, $type, $page, $numItems, $dateFrom, $dateTo)
    {
        $request =
            'SELECT '
                . 's.name '
                . ', i1.name instructorName1 '
                . ', i2.name instructorName2 '
                . ', i3.name instructorName3 '
                . ', DATE_FORMAT(s.startDate, "%d.%m.%Y") startDate '
                . ', s.durationDay '
                . ', s.durationHour '
                . ', s.language '
                . ', s.costDeposit '
                . ', s.costSeminar '
                . ', s.description '
                . ', s.sertSeminar '
                . ', s.authSeminar '
                . ', s.id '
                . ', c.name cityName '
                . ', s.fkInstructorId1 '
                . ', s.fkInstructorId2 '
                . ', s.fkInstructorId3 '
            . 'FROM '
//                . '`seminar` s LEFT JOIN `instructor` i2 ON (s.`fkInstructorId2`=i2.`id`) LEFT JOIN `instructor` i3 ON (s.`fkInstructorId3`=i3.`id`) '
                . '`seminar` s LEFT JOIN `instructor` i2 ON (s.`fkInstructorId2`=i2.`fkUserId`) LEFT JOIN `instructor` i3 ON (s.`fkInstructorId3`=i3.`fkUserId`) '
                . ', `city` c '
                . ', `instructor` i1 '
            . 'WHERE '
                . 's.fkCityId=c.id '
                //. 'AND s.fkInstructorId1=i1.id '
                . 'AND s.fkInstructorId1=i1.fkUserId '
                . 'AND s.publish=1 '
                . 'AND s.startDate>=now() '

        ;
        if ($cityId) {
            $request .= 'AND s.fkCityId=:cityId ';
        }
        switch ($type) {
            case 'sert':
                $request .= 'AND s.sertSeminar=1 ';
                break;
            case 'auth':
                $request .= 'AND s.authSeminar=1 ';
                break;
            case 'free':
                $request .= 'AND (s.costDeposit+s.costSeminar)=0 ';
                break;
        }
        if ($dateFrom) {
            $request .= "AND s.startDate>=STR_TO_DATE('" . $dateFrom . "', '%Y-%m-%d') ";
        }
        if ($dateTo) {
            $request .= "AND s.startDate<=STR_TO_DATE('" . $dateTo . "', '%Y-%m-%d') ";
        }

        $request .=
                'ORDER BY '
                    . 's.startDate '
                . 'LIMIT '
                    . $page . ', ' . $numItems
        ;

        $command = Yii::$app->db->createCommand($request);
        if ($cityId) {
            $command->bindValue(':cityId', $cityId);
        }
        return $command->queryAll();
    }

    public function seminarsInstructor($id)
    {
        $request =
            'SELECT '
                . 's.name '
                . ', DATE_FORMAT(s.startDate, "%d.%m.%Y") startDate '
                . ', s.sertSeminar '
                . ', s.authSeminar '
                . ', s.id '
                . ', c.name nameCity '
                . ', s.costDeposit '
                . ', s.costSeminar '
                . ', s.publish '
            . 'FROM '
                . '`seminar` s '
                . ', `city` c '
            . 'WHERE '
                . 's.fkCityId=c.id '
                . 'AND (s.`fkInstructorId1` = :id '
                . 'OR s.`fkInstructorId2` = :id '
                . 'OR s.`fkInstructorId3` = :id) '
                . 'AND s.publish=1 '
                . 'AND s.startDate>=now() '
            . 'ORDER BY '
                . 'DATE(s.startDate) asc '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':id', $id)
            ->queryAll();
    }

    /**
     * Возвращает русский тип семинара английскому типу или пустую строку
     * /
    public static function rusType($enType)
    {
        if ($enType == self::EN_SETR) {
            return self::RUS_SETR;
        }
        if ($enType == self::EN_AUTHOR) {
            return self::RUS_AUTHOR;
        }
        return '';
    }

    /**
     * Возвращает английский тип семинара русскому типу или пустую строку
     * /
    public static function enType($rusType)
    {
        if ($rusType == self::RUS_SETR) {
            return self::EN_SETR;
        }
        if ($rusType == self::RUS_AUTHOR) {
            return self::EN_AUTHOR;
        }
        return '';
    }
*/
    /**
     * Возвращает продолжительность в днях в прописном виде
     */
    public static function strDay($duration)
    {
        $d1 = $duration % 10;
        $d2 = $duration % 100;
        return ($d1 == 1 && $d2 != 11 ? 'день' : ($d1 >= 2 && $d1 <= 4 && ($d2 < 10 || $d2 >= 20) ? 'дня' : 'дней'));
    }

    /**
     * Возвращает продолжительность в часах в прописном виде
     */
    public static function strHour($duration)
    {
        $d1 = $duration % 10;
        $d2 = $duration % 100;
        return ($d1 == 1 && $d2 != 11 ? 'час' : ($d1 >= 2 && $d1 <= 4 && ($d2 < 10 || $d2 >= 20) ? 'часа' : 'часов'));
    }

    /**
     * Возвращает количество участников в часах в прописном виде
     */
    public static function strParticipants($num)
    {
        $d1 = $num % 10;
        $d2 = $num % 100;
        return ($d1 == 1 && $d2 != 11 ? 'человек' : ($d1 >= 2 && $d1 <= 4 && ($d2 < 10 || $d2 >= 20) ? 'человека' : 'человек'));
    }

    /**
     * Возвращает заголовок Инструктор в прописном виде
     */
    public static function strInstructor($instructorId1, $instructorId2, $instructorId3)
    {
        if ($instructorId2 || $instructorId3) {
            return 'Инструкторы';
        }
        return 'Инструктор';
    }

    /**
     * Возвращает заголовок Языки в прописном виде
     */
    public static function strLanguage($arr)
    {
        if ($arr && count($arr)>1) {
            return 'Языки преподавания';
        }
        return 'Язык преподавания';
    }

}
