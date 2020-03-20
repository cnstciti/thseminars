<?php
namespace frontend\models\auth;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\Html;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это имя пользователя уже занято.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это адрес электронной почты уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
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
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        $verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);

        // Получатель
        $sendTo   = $this->email;

        // Формирование заголовка письма
        $subject  = 'Подтверждение регистрации на ' . Yii::$app->name;

        // Формирование тела письма
        $msg  = "<html><body style='font-family:Arial,sans-serif;'>";
        $msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>" . $subject . "</h2>\r\n";
        $msg .= "<p>Приветствуем, " . Html::encode($user->username) . ",</p>\r\n";
        $msg .= "<p>Перейдите по ссылке ниже, чтобы подтвердить свою электронную почту:</p>\r\n";
        $msg .= "<p>" . Html::a(Html::encode($verifyLink), $verifyLink) . "</p>\r\n";
        $msg .= "</body></html>";

        // Отправитель
        $headers  = "From: ". Yii::$app->params['supportEmail'] . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";

        // отправка сообщения
        if(@mail($sendTo, $subject, $msg, $headers)) {
            return true;
        } else {
            return false;
        }
    }
}
