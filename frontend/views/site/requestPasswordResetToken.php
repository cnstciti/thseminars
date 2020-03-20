<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановить пароль';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div id="site-request-password-reset" class="mt-4">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните вашу электронную почту. Ссылка для сброса пароля будет отправлена на указанный адрес.</p>

    <div class="row thumbnail">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
