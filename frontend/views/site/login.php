<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход в Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="site-login" class="mt-4">
    <h1>Вход в Личный кабинет инструктора</h1>

    <p>Пожалуйста, заполните следующие поля для входа в Личный кабинет:</p>

    <div class="row thumbnail">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'cb']) ?>

                <p class="ext">
                    Если Вы забыли пароль, Вы можете <?= Html::a('восстановить его', ['site/request-password-reset'], ['class' => 'link-leaving link']) ?>.
                </p>
                <p class="ext">
                    Необходима проверка электронной почты? <?= Html::a('Отправить повторно', ['site/resend-verification-email'], ['class' => 'link-leaving link']) ?>
                </p>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
