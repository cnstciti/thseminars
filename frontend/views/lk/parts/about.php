<?php

/* @var $this yii\web\View */
/* @var $instructor frontend\models\Insructor */

use yii\helpers\Html;

$about = $instructor['about'] ? $instructor['about'] : '[Напишите информацию о себе]';
?>
<div id="lk-about">
    <div class="row thumbnail pt-3">
        <div class="col">
            <?= $about ?>
        </div>
        <div class="col text-right">
            <?= Html::a('Изменить', ['lk/edit-about'], ['class' => 'btn btn-outline-success btn-lg']) ?>
        </div>
    </div>
</div>
