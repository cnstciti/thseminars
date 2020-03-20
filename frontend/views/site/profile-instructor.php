<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\seminar\Seminar */
/* @var $cities frontend\models\Cities */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\instructor\Language;
use frontend\models\seminar\Seminar;
use frontend\models\instructor\Instructor;
use frontend\models\instructor\Certificate;
if (!function_exists('profile')) {
    function profile($instructor, $nameProfile, $img)
    {
        if ($instructor[$nameProfile]) {
            $profile = $instructor->getCorrectUrl($instructor[$nameProfile]);
            $src = Yii::getAlias('@social') . $img . '.png';
            return Html::a(
                '<img src="' . $src . '" title = "' . $profile . '"  alt = "' . $profile . '" />',
                $profile,
                ['target' => '_blank', 'class' => 'ml-2']
            );
        }
    }
}
?>
<div id="instructor">
    <div class="row">
        <div class="col-auto">
            <img src="<?= $instructor->avatar($instructor['avatar']) ?>" class="<?= $instructor->avatarClass($instructor['avatar']) ?> thumbnail" alt="" />
        </div>
        <div class="col">
            <div class="name pb-3">

            <? if ($link): ?>
                <a href="<?= Url::to(['instructor', 'id' => $instructor['fkUserId']]) ?>" class="link-leaving link"><?= $instructor['name'] ?></a>
            <? else: ?>
                <?= $instructor['name'] ?>
            <? endif; ?>

            </div>

        <? if (unserialize($instructor['certificate'])): ?>
            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-list-alt pr-2 pl-2" title="Сертификаты"></span>
                <?= implode(', ', (new Certificate)->selected(unserialize($instructor['certificate']))) ?>
            </div>
        <? endif; ?>

        <? if (unserialize($instructor['language'])): ?>
            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-bullhorn pr-2 pl-2" title="Язык преподавания"></span>
                <?= implode(', ', (new Language)->selected(unserialize($instructor['language']))) ?>
            </div>
        <? endif; ?>

        <? if ($instructor['phone']): ?>
            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-phone-alt pr-2 pl-2" title="Телефон"></span>
                <a href="tel:<?= $instructor['phone'] ?>" target="_blank" class="link-leaving link"><?= $instructor['phone'] ?></a>
            </div>
        <? endif; ?>

        <? if ($instructor['email']): ?>
            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-envelope pr-2 pl-2" title="Email" class="link"></span>
                <a href="mailto:<?= $instructor['email'] ?>" target="_blank" class="link-leaving link"><?= $instructor['email'] ?></a>
            </div>
        <? endif; ?>

        <? if ($instructor['www']): ?>
            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-globe pr-2 pl-2" title="Личная страница"></span>
                <a href=":<?= $instructor->getCorrectUrl($instructor['www']) ?>" target="_blank" class="link-leaving link"><?= $instructor['www'] ?></a>
            </div>
        <? endif; ?>

            <div class="row">
                <div class="col pl-4 pb-3 pt-4 social">

            <?
                echo profile($instructor, 'profileFb', 'fb');
                echo profile($instructor, 'profileIg', 'ig');
                echo profile($instructor, 'profileOk', 'ok');
                echo profile($instructor, 'profileTw', 'tw');
                echo profile($instructor, 'profileVk', 'vk');
                echo profile($instructor, 'profileYt', 'yt');
                echo profile($instructor, 'profileTh', 'th');
                echo profile($instructor, 'profileSkype', 'skype');
                echo profile($instructor, 'profileViber', 'viber');
                echo profile($instructor, 'profileWs', 'ws');
            ?>

                </div>
            </div>

        </div>

    </div>
</div>

