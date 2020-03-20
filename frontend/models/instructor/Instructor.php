<?php
/**
 * Этот файл отвечает за методы обращения к таблице "Инструкторы"
 *
 */

namespace frontend\models\instructor;

use Yii;
use yii\db\ActiveRecord;

/**
 * Класс таблицы "Инструкторы"
 *
 * @author Constantin Ogloblin <cnst@mail.ru>
 * @since 1.0.0
 */

class Instructor extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                'name',
                'required',
                'message' => 'Необходимо заполнить поле "Имя"',
            ],
            [
                [
                    'name',
                    'phone',
                    'email',
                    'www',
                    'profileFb',
                    'profileIg',
                    'profileOk',
                    'profileTw',
                    'profileVk',
                    'profileYt',
                    'profileTh',
                    'profileSkype',
                    'profileViber',
                    'profileWs',
                    'about',
                ],
                'trim'
            ],
            [
                [
                    'avatar',
                    'certificate',
                    'language',
                    'phone',
                    'email',
                    'www',
                    'profileFb',
                    'profileIg',
                    'profileOk',
                    'profileTw',
                    'profileVk',
                    'profileYt',
                    'profileTh',
                    'profileSkype',
                    'profileViber',
                    'profileWs',
                    'about',
                ],
                'safe',
            ],
            ['avatar', 'image', 'extensions' => 'png, jpeg, jpg, gif',
                'minWidth'  => 100,
                'maxWidth'  => 500,
                'minHeight' => 100,
                'maxHeight' => 500,
                'maxSize'   => 1024*512, // размер файла должен быть меньше 500Кб
            ],
            ['name', 'string', 'length' => [3, 40]],
            ['phone', 'string', 'length' => [10, 20]],
            ['www', 'string', 'length' => [5, 30]],
            [['profileFb', 'profileIg'], 'string', 'length' => [14, 40]],
            ['profileOk', 'string', 'length' => [15, 40]],
            [['profileTw', 'profileYt'], 'string', 'length' => [12, 40]],
            ['profileVk', 'string', 'length' => [9, 40]],
            ['profileTh', 'string', 'length' => [17, 40]],
            [['www', 'profileFb', 'profileIg', 'profileOk', 'profileTw', 'profileVk', 'profileYt', 'profileTh'], 'url', 'defaultScheme' => 'http'],
            [['profileSkype', 'profileViber', 'profileWs'], 'string', 'length' => [2, 20]],
            ['email', 'email'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * See Model class for more details
     *
     * @return array attribute labels (name => label).
     */
    public function attributeLabels()
    {
        return [
            'avatar'       => 'Фотография',
            'name'         => 'Имя',
            'certificate'  => 'Сертификаты',
            'language'     => 'Язык преподавания',
            'phone'        => 'Телефон',
            'www'          => 'Личная страница в интернете',
            'profileFb'    => 'Facebook',
            'profileIg'    => 'Instagram',
            'profileOk'    => 'Одноклассники',
            'profileTw'    => 'Twitter',
            'profileVk'    => 'ВКонтакте',
            'profileYt'    => 'YouTube',
            'profileTh'    => 'ThetaHealing',
            'profileSkype' => 'Skype',
            'profileViber' => 'Viber',
            'profileWs'    => 'WhatsApp',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$insert && !$this->avatar) {
                $this->avatar = $this->oldAttributes['avatar'];
            }
            // удаляем старый аватар, если подгружен новый
            if ($this->oldAttributes['avatar'] && $this->avatar != $this->oldAttributes['avatar']) {
                unlink(Yii::getAlias('@avatarInstructorWWW') . '/' . $this->oldAttributes['avatar']);
            }
            return true;
        }
        return false;
    }

    public function balance($userId)
    {
        $request =
            'SELECT '
                . 'balance '
            . 'FROM '
                . '`instructor` '
            . 'WHERE '
                . 'fkUserId=:userId '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':userId', $userId)
            ->queryScalar();
    }

    /**
     * Изменение баланса
     */
    public function changeBalance($userId, $sum)
    {
        $request =
            'UPDATE '
                . '`instructor` '
            . 'SET '
                . '`balance`=`balance`+:sum '
            . 'WHERE '
                . 'fkUserId=:userId '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':sum',       $sum)
            ->bindValue(':userId',     $userId)
            ->execute();
    }

    public function getCorrectUrl($url) {
        $arr = parse_url($url);
        if (array_key_exists('scheme', $arr)) {
            return $url;
        }
        return 'http://' . $url;
    }

    public function isExistById($id)
    {
        $request =
            'SELECT '
                . 'count(id) '
            . 'FROM '
                . '`instructor` '
            . 'WHERE '
            .    'fkUserId=:id '
        ;
        return Yii::$app->db->createCommand($request)
            ->bindValue(':id', $id)
            ->queryScalar();
    }

    public function avatar($avatarPhoto) {
        if ($avatarPhoto) {
            return Yii::getAlias('@avatarInstructor') . $avatarPhoto;
        }
        return Yii::getAlias('@images') . '/no-avatar.png';
    }

    public function avatarClass($avatarPhoto) {
        if ($avatarPhoto) {
            list($width, $height, $type, $attr) = getimagesize(Yii::getAlias('@avatarInstructor') . $avatarPhoto);
            if ($width > $height) {
                return 'avatar-width';
            }
        }
        return 'avatar-height';
    }

}
