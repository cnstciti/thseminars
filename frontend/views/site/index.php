<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use frontend\models\instructor\Language;
use frontend\models\seminar\Seminar;

$this->registerCssFile('yii/npm-asset/bootstrap/dist/css/bootstrap.css', ['depends' => ['frontend\assets\AppAsset']]);

// Наименование семинара
function seminarName($seminar)
{
    $title = '';
    if ($seminar['sertSeminar']) {
        $title = 'Сертифицированный';
    }
    if ($seminar['authSeminar']) {
        $title = 'Авторский';
    }
    return $title . ' семинар "' . $seminar['name'] . '"';
}

// Подстказка начала даты семинара
function seminarStartDateTitle($seminar)
{
    $firstDay = $seminar['startDate'];
    if ($seminar['durationDay'] > 1) {
        $secondDay = mktime(0, 0, 0,
            date('m', strtotime($firstDay)),
            date('d', strtotime($firstDay)) + $seminar['durationDay'] - 1,
            date('Y', strtotime($firstDay))
        );
        $secondDay = date("d.m.Y", $secondDay);
        return 'Начало семинара - ' . getDayRus($firstDay) . '. ' .
            'Окончание семинара - ' . getDayRus($secondDay);
    }
    return 'Начало семинара - ' . getDayRus($firstDay);
}

// Дата начала семинара
function seminarStartDate($seminar)
{
    $firstDay = $seminar['startDate'];
    if ($seminar['durationDay'] > 1) {
        $secondDay = mktime(0, 0, 0,
            date('m', strtotime($firstDay)),
            date('d', strtotime($firstDay)) + $seminar['durationDay'] - 1,
            date('Y', strtotime($firstDay))
        );
        $secondDay = date("d.m.Y", $secondDay);
        return Yii::$app->formatter->asDate($firstDay, 'long') . ' - ' .
            Yii::$app->formatter->asDate($secondDay, 'long');
    }
    return Yii::$app->formatter->asDate($firstDay, 'long');
}

// День недели по-русски
function getDayRus($date) {
    $days = array(
        'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
        'Четверг', 'Пятница', 'Суббота'
    );
    return $days[(date('w', strtotime($date)))];
}

$this->title = 'Главная';
$class = 'link-leaving item mt-2 mb-2 mr-3 ml-3';
?>
<div id="main">

    <div class="row">
        <div class="col mt-4 mb-4" id="welcome">
            Мы рады приветствовать вас на сайте, посвященному семинарам ТетаХилинг. Если вам интересна методика
            ТетаХилинг и есть желание получить больше знаний об этом методе, то вы можете найти и выбрать необходимый семинар ниже.
            Если вы инструктор, то вам нужно пройти регистрацию на сайте и разместить информацию о проведении своих
            семинаров.
        </div>
    </div>

    <div class="row">
        <div class="col mb-3" id="count">
            Найдено семинаров: <b><?= $countActiveSeminars ?></b>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-auto">
            <div class="row">
                <div class="col thumbnail mr-sm-3" id="menu">
                    <div class="row">
                        <div class="col mt-2">
                            <b>Дата начала семинара</b>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <?
                            $form = ActiveForm::begin(['method' => 'post',
                                'options' => [
                                    'class' => 'form-inline',
                                ],
                            ]);

                            echo $form->field($periodDate, 'dateFrom')->widget(DatePicker::classname(), [
                                'size'          => 'sm',
                                'type'          => DatePicker::TYPE_INPUT,
                                'bsVersion'     => '4.x',
                                'options'       => [
                                    'placeholder'  => 'с',
                                    'autocomplete' => 'off',
                                    'class'        => 'mr-2 pt-2',
                                ],
                                'pluginOptions' => [
                                    'startDate'      => date("d.m.Y"),
                                    'format'         => 'dd.mm.yyyy',
                                    'todayHighlight' => true,
                                    'autoclose'      => true,
                                    'language'       => 'ru',
                                ]
                            ])->label(false);

                            echo $form->field($periodDate, 'dateTo')->widget(DatePicker::classname(), [
                                'size'          => 'sm',
                                'type'          => DatePicker::TYPE_INPUT,
                                'bsVersion'     => '4.x',
                                'options'       => [
                                    'placeholder'  => 'по',
                                    'autocomplete' => 'off',
                                    'class'        => 'mr-2 pt-2',
                                ],
                                'pluginOptions' => [
                                    'startDate'      => date("d.m.Y"),
                                    'format'         => 'dd.mm.yyyy',
                                    'todayHighlight' => true,
                                    'autoclose'      => true,
                                    'language'       => 'ru',
                                ]
                            ])->label(false);

                            echo Html::submitButton('>>', ['class' => 'btn btn-primary']);

                            ActiveForm::end();
                        ?>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col mt-sm-3">
                            <b>Город</b>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <a class="<?= $class ?>" href="<?= Url::to(['index']) ?>">Все города</a> <span><?= $countActiveCities ?></span>
                        </div>
                    </div>

                    <? foreach ($cities as $city): ?>

                    <div class="row">
                        <div class="col">
                            <a class="<?= $class ?>" href="<?= Url::to(['index', 'city' => $city['nameEnglish']]) ?>"><?= $city['name'] ?></a> <span><?= $city['num'] ?></span>
                        </div>
                    </div>

                    <? endforeach;?>

                    <div class="row">
                        <div class="col mt-2">
                            <b>Тип семинара</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a class="<?= $class ?>" href="<?= Url::to(['index', 'type' => 'sert']) ?>">Сетрифицированный</a> <span><?= $types[0]['sert'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a class="<?= $class ?>" href="<?= Url::to(['index', 'type' => 'auth']) ?>">Авторский</a> <span><?= $types[0]['auth'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a class="<?= $class ?>" href="<?= Url::to(['index', 'type' => 'free']) ?>">Бесплатный</a> <span><?= $types[0]['free'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="row">
                <div class="col">

        <? foreach ($seminars as $seminar): ?>
            <div class="row seminar thumbnail pt-3 pb-3">
                <div class="col">
                    <div class="row">
                        <div class="col mb-4">
                            <a class="link-leaving name" href="<?= Url::to(['site/seminar', 'id' => $seminar['id']]) ?>">
                                <?= seminarName($seminar) ?>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col data ml-4 mb-4 mr-4 pt-2">
                            <div class="row">
                                <div class="col-12 col-sm col-md-6 col-lg-5 text-nowrap">
                                    <span class="glyphicon glyphicon-calendar pr-2" title="<?= seminarStartDateTitle($seminar) ?>"></span> <?= seminarStartDate($seminar) ?>
                                </div>
                                <div class="col-12 col-sm col-md-3 col-lg-3 text-nowrap">
                                    <span class="glyphicon glyphicon-map-marker pr-2" title="Место проведения"></span> г. <?= $seminar['cityName'] ?>
                                </div>
                                <div class="col-12 col-sm col-md-2 col-lg-2 text-nowrap">
                                    <span class="glyphicon glyphicon-time pr-2" title="Продолжительность"></span> <?= $seminar['durationHour'] . ' ' . Seminar::strHour($seminar['durationHour']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4 col-lg-3 mb-3">
                            <div class="row">
                                <div class="col title mb-1">
                                    <b><?= Seminar::strInstructor($seminar['fkInstructorId1'], $seminar['fkInstructorId2'], $seminar['fkInstructorId3']) ?></b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-1 ml-4">
                                    <a class="link-leaving link-text" href="<?= Url::to(['instructor', 'id' => $seminar['fkInstructorId1']]) ?>"><?= $seminar['instructorName1'] ?></a>
                                </div>
                            </div>

                            <? if ($seminar['instructorName2']): ?>

                            <div class="row">
                                <div class="col mt-2 ml-4">
                                    <a class="link-leaving link-text" href="<?= Url::to(['instructor', 'id' => $seminar['fkInstructorId2']]) ?>"><?= $seminar['instructorName2'] ?></a>
                                </div>
                            </div>

                            <? endif; ?>

                            <? if ($seminar['instructorName3']): ?>

                            <div class="row">
                                <div class="col mt-2 ml-4">
                                    <a class="link-leaving link-text" href="<?= Url::to(['instructor', 'id' => $seminar['fkInstructorId3']]) ?>"><?= $seminar['instructorName3'] ?></a>
                                </div>
                            </div>

                            <? endif; ?>

                        </div>
                        <div class="col-12 col-sm-4 col-lg-3 mb-3">
                            <div class="row">
                                <div class="col title mb-1">
                                    <b><?= Seminar::strLanguage(unserialize($seminar['language'])) ?></b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text mt-1 ml-4">
                                    <?= implode(', ', (new Language)->selected(unserialize($seminar['language']))) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-auto mb-3">
                            <div class="row">
                                <div class="col title mb-1">
                                    <b>Стоимость, руб.</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text ml-4">
                                    <table class="table m-0">
<? /*
                                        <thead>
                                        <tr>
                                            <th colspan="2">Стоимость, руб.</th>
                                        </tr>
                                        </thead>
 */ ?>
                                        <tbody>
                                        <tr>
                                            <td>Общая:</td>
                                            <td><?= number_format($seminar['costDeposit']+$seminar['costSeminar'], 2, ',', ' ' ) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Депозит:</td>
                                            <td><?= number_format($seminar['costDeposit'], 2, ',', ' ' ) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Семинар:</td>
                                            <td><?= number_format($seminar['costSeminar'], 2, ',', ' ' ) ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <? /*
                                    <div class="row">
                                        <div class="col-6 mt-1">
                                            Общая:
                                        </div>
                                        <div class="col-6 text-right mt-1">
                                            <?= number_format($seminar['costDeposit']+$seminar['costSeminar'], 2, ',', ' ' ) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-1">
                                            Депозит:
                                        </div>
                                        <div class="col-6 text-right mt-1">
                                            <?= number_format($seminar['costDeposit'], 2, ',', ' ' ) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-1">
                                            Семинар:
                                        </div>
                                        <div class="col-6 text-right mt-1">
                                            <?= number_format($seminar['costSeminar'], 2, ',', ' ' ) ?>
                                        </div>
                                    </div>
 */ ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                            <div>
                                <a href="<?= Url::to(['seminar', 'id' => $seminar['id']]) ?>" class="btn btn-outline-danger btn-lg">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <? endforeach; ?>

            <div class="row">
                <div class="col">

                <?= LinkPager::widget([
                        'pagination' => $pagination,
                        'options'    => [
                            'class'  => 'pagination'
                        ]
                    ]) ?>

                </div>
            </div>

                </div>
            </div>
        </div>

    </div>
</div>
