<?php


namespace frontend\models\auth;

use Yii;
use common\models\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
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
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => 'Нет пользователя с этим адресом электронной почты.'
            ],
        ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $user = User::findOne([
            'email' => $this->email,
            'status' => User::STATUS_INACTIVE
        ]);

        if ($user === null) {
            return false;
        }

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
        /*
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Подтверждение регистрации на ' . Yii::$app->name)
            ->send();
        */
    }
}
