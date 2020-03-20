<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seminar */

?>
<div id="seminar-nopublish">

    <div class="row thumbnail">
        <div class="col">
            <p>Семинар не может быть опубликован.</p>
            <p>Вы опубликовали бесплатно: <?= $maxPubSeminar ?> семинаров.</p>
            <p>В ближайшее время Вам будут доступны функции размещения семинаров на платной основе.</p>
            <p>Уведомление о работе новых функциях прийдет к Вам на электронный адрес, указанный при регистрации.</p>
        </div>
        <div class="col-1">
            <a href="<?= Url::to(['lk/index', 'tab' => 'seminar']) ?>" class="btn btn-outline-danger">К списку семинаров</a>
        </div>
    </div>

</div>
