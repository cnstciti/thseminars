<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seminar */

$this->title = Yii::t('app', 'Пополнение баланса');
?>
<div id="balans">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><b>Временно</b> пополнение баланса осуществляется только через Сбербан-Онлайн.</p>
    <p>Номер карты для оплаты: ХХХХ ХХХХ ХХХХ ХХХХ.</p>
    <p>В "Сообщении получателю" <b>обязательно</b> указываете Ваш логин: <?= Yii::$app->user->identity->username ?>.</p>
    <p>Стоимость публикации одного семинара: <?= Yii::$app->params['myCostSeminar'] ?> рублей.</p>
    <p>Увеличение баланса осуществляется в течение 12 часов после прихода денежных средств.</p>

</div>
