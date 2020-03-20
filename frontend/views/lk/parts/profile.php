<?php

/* @var $this yii\web\View */
/* @var $instructor frontend\models\Insructor */

use yii\helpers\Html;
use frontend\models\instructor\Certificate;
use frontend\models\instructor\Language;

$noInformation = '[Нет информации]';

if ($instructor['phone']) {
    $phone = '<a class="link-leaving link" href="tel:' . $instructor['phone'] . '" target="_blank">' . $instructor['phone'] . '</a>';
} else {
    $phone = $noInformation;
}

if ($instructor['email']) {
    $email = '<a class="link-leaving link" href="mailto:' . $instructor['email'] . '" target="_blank">' . $instructor['email'] . '</a>';
} else {
    $email = $noInformation;
}

if ($instructor['www']) {
    $www = '<a class="link-leaving link" href="' . $instructor->getCorrectUrl($instructor['www']) . '" target="_blank">' . $instructor['www'] . '</a>';
} else {
    $www = $noInformation;
}

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
?>
<div id="instructor">
    <div class="row thumbnail pt-3">
        <div class="col-auto">
            <img src="<?= $instructor->avatar($instructor['avatar']) ?>" class="<?= $instructor->avatarClass($instructor['avatar']) ?> thumbnail" alt="" />
        </div>
        <div class="col-12 col-sm-auto">
            <div class="name pb-3">
                <?= $instructor['name'] ?>
            </div>

            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-list-alt pr-2 pl-2" title="Сертификаты"></span>
                <?= unserialize($instructor['certificate']) ? implode(', ', (new Certificate)->selected(unserialize($instructor['certificate']))) : $noInformation ?>
            </div>

            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-bullhorn pr-2 pl-2" title="Язык преподавания"></span>
                <?= unserialize($instructor['language']) ? implode(', ', (new Language)->selected(unserialize($instructor['language']))) : $noInformation ?>
            </div>

            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-phone-alt pr-2 pl-2" title="Телефон"></span>
                <?= $phone ?>
            </div>

            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-envelope pr-2 pl-2" title="Email"></span>
                <?= $email ?>
            </div>

            <div class="pb-1 pt-1">
                <span class="glyphicon glyphicon-globe pr-2 pl-2" title="Личная страница"></span>
                <?= $www ?>
            </div>

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
        <div class="col-12 col-md text-right">
            <?= Html::a('Изменить', ['lk/edit-profile'], ['class' => 'btn btn-outline-success btn-lg']) ?>
        </div>

    </div>
</div>
