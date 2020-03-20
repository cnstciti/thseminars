<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Подтверждение email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="site-resend-verification-email" class="mt-4">
    <h1>Отправить письмо с подтверждением повторно</h1>

    <p>Пожалуйста, заполните вашу электронную почту. Вам будет отправлено письмо с подтверждением.</p>

    <div class="row thumbnail">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
