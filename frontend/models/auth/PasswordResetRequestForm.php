<?php
namespace frontend\models\auth;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Нет пользователя с этим адресом электронной почты.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

        // Получатель
        $sendTo   = $this->email;

        // Формирование заголовка письма
        $subject  = 'Восстановление пароля на ' . Yii::$app->name;

        // Формирование тела письма
        $msg  = "<html><body style='font-family:Arial,sans-serif;'>";
        $msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>" . $subject . "</h2>\r\n";
        $msg .= "<p>Приветствуем, " . Html::encode($user->username) . ",</p>\r\n";
        $msg .= "<p>Чтобы сбросить пароль, перейдите по ссылке ниже:</p>\r\n";
        $msg .= "<p>" . Html::a(Html::encode($resetLink), $resetLink) . "</p>\r\n";
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
        /*
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        */
    }
}
