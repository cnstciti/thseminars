<?php

/* @var $this yii\web\View */
/* @var $instructor frontend\models\Insructor */

use yii\helpers\Url;
use frontend\models\instructor\Certificate;
use frontend\models\instructor\Language;
use frontend\models\seminar\Seminar;
use yii\bootstrap\Html;

?>
<div id="account">
    <div class="row thumbnail">
        <div class="col-12">
            <div class="row">
                <div class="col-1">
                    Логин:
                </div>
                <div class="col">
                    <?= $user->username ?>
                </div>
                <div class="col text-right">
                    <a href="<?= Url::to(['lk/edit-password'] )?>" class="btn btn-outline-success">Изменить пароль</a>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    Email:
                </div>
                <div class="col">
                    <?= $user->email ?>
                </div>
                <div class="col text-right">
                    <a href="<?= Url::to(['lk/edit-email'] )?>" class="btn btn-outline-success">Изменить</a>
                </div>
            </div>
        </div>
    </div>
</div>
