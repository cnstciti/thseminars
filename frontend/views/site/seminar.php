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

// День недели по-русски
function getDayRus($date) {
    $days = array(
        'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
        'Четверг', 'Пятница', 'Суббота'
    );
    return $days[(date('w', strtotime($date)))];
}

$title = '';
$logo = '';
if ($model['sertSeminar']) {
    $title = 'Сертифицированный';
    $logo = Yii::getAlias('@logoSertSeminar') . $model['logo'];
}
if ($model['authSeminar']) {
    $title = 'Авторский';
    $logo = Yii::getAlias('@logoAuthSeminar') . $model['logo'];
}

$this->title = $title . ' семинар "' . $model['name'] . '"';

$firstDay = $model['startDate'];
if ($model['durationDay']>1) {
    $secondDay = mktime(0, 0, 0,
        date('m', strtotime($firstDay)),
        date('d', strtotime($firstDay))+$model['durationDay']-1,
        date('Y', strtotime($firstDay))
    );
    $secondDay = date("d.m.Y", $secondDay);
    $strDate = Yii::$app->formatter->asDate($firstDay, 'long') . ' - ' .
        Yii::$app->formatter->asDate($secondDay, 'long');
    $titleDate = 'Начало семинара - ' . getDayRus($firstDay) . '. ' .
        'Окончание семинара - '. getDayRus($secondDay);
} else {
    $strDate = Yii::$app->formatter->asDate($firstDay, 'long');
    $titleDate = 'Начало семинара - ' . getDayRus($firstDay);
}
?>
<div id="seminar">

    <div class="row thumbnail mt-4">

        <? if ($logo): ?>
            <div class="col-auto">
                <img src="<?= $logo ?>" class="thumbnail" alt="" />
            </div>
        <? endif; ?>

        <div class="col">
            <div class="row">
                <div class="col name">
                    <?= $this->title ?>
                </div>
            </div>
            <div class="row data pt-4">
                <div class="col-auto pb-3">
                    <div class="pb-1 pt-1">
                        <span class="glyphicon glyphicon-calendar pr-2 pl-2" title="<?= $titleDate ?>"></span>
                        <?= $strDate ?>
                    </div>
                    <div class="pb-1 pt-1">
                        <span class="glyphicon glyphicon-time pr-2 pl-2" title="Продолжительность"></span>
                        <?= $model['durationHour'] . ' ' . Seminar::strHour($model['durationHour']) ?>
                    </div>
                    <div class="pb-1 pt-1">
                        <span class="glyphicon glyphicon-map-marker pr-2 pl-2" title="Место проведения"></span>
                        г. <?= $model['cityName'] ?>
                    </div>
                    <div class="pb-1 pt-1">
                        <span class="glyphicon glyphicon-user pr-2 pl-2" title="Количество участников"></span>
                        <?= $model['numberParticipants'] . ' ' . Seminar::strParticipants($model['numberParticipants']) ?>
                    </div>
                    <div class="pb-1 pt-1">
                        <span class="glyphicon glyphicon-bullhorn pr-2 pl-2" title="Язык преподавания"></span>
                        <?= implode(', ', (new Language)->selected(unserialize($model['language']))) ?>
                    </div>
                </div>
                <div class="col col-md-2">
                    <table class="table tbl m-0">
                        <thead>
                        <tr>
                            <th colspan="2">Стоимость, <span class="glyphicon glyphicon-rub"></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Общая:</td>
                            <td><?= number_format($model['costDeposit']+$model['costSeminar'], 2, ',', ' ' ) ?></td>
                        </tr>
                        <tr>
                            <td>Депозит:</td>
                            <td><?= number_format($model['costDeposit'], 2, ',', ' ' ) ?></td>
                        </tr>
                        <tr>
                            <td>Семинар:</td>
                            <td><?= number_format($model['costSeminar'], 2, ',', ' ' ) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col block-title">
            <?= Seminar::strInstructor($model['fkInstructorId1'], $model['fkInstructorId2'], $model['fkInstructorId3']) ?>
        </div>
    </div>

    <div class="row thumbnail">
        <div class="col">
            <div class="row">
                <div class="col">
                    <?= $this->render('profile-instructor', [
                        'instructor'  => $instructor1,
                        'link' => true,
                    ]) ?>
                </div>
            </div>
        <? if(!empty($instructor2)): ?>
            <div class="row">
                <div class="col">
                    <?= $this->render('profile-instructor', [
                        'instructor'  => $instructor2,
                        'link' => true,
                    ]) ?>
                </div>
            </div>
        <? endif; ?>
        <? if(!empty($instructor3)): ?>
            <div class="row">
                <div class="col">
                    <?= $this->render('profile-instructor', [
                        'instructor'  => $instructor3,
                        'link' => true,
                    ]) ?>
                </div>
            </div>
        <? endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col block-title">
            Описание семинара
        </div>
    </div>

    <div class="row thumbnail">
        <div class="col-12">
            <?= $model['description'] ?>
        </div>
    </div>

<? if ($model['schedule']): ?>

    <div class="row">
        <div class="col block-title">
            Расписание семинара
        </div>
    </div>

    <div class="row thumbnail">
        <div class="col-12">
            <?= $model['schedule'] ?>
        </div>
    </div>

<? endif; ?>

</div>
