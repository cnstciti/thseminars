<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\instructor\Certificate;
use frontend\models\instructor\Language;
use frontend\models\seminar\Seminar;

$this->title = 'Инструктор';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="profile">
    <div class="row thumbnail mt-4">
        <div class="col">
            <?= $this->render('profile-instructor', [
                'instructor'  => $instructor,
                'link' => false,
            ]) ?>
        </div>
    </div>

    <? if ($instructor->about): ?>

    <div class="row">
        <div class="col block-title">
            Обо мне
        </div>
    </div>

    <div class="row thumbnail">
        <div class="col">
            <?= $instructor->about ?>
        </div>
    </div>

    <? endif; ?>

    <div class="row">
        <div class="col block-title">
            Мои семинары
        </div>
    </div>

    <div class="row">
        <div class="col <?/*table-responsive*/?> thumbnail">
            <table class="table tbl m-0"  style="margin: 0">
                <thead>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-md-2 col-sm-3 col-6 ">Дата начала</div>
                            <div class="col-md-5 col-sm-5 col-12 ">Наименование</div>
                            <div class="col-md-3 col-sm-3 col-12 hidden visible-sm visible-md visible-lg visible-xl">Место проведения</div>
                            <div class="col-md-2 col-sm-2 col-12 hidden visible-sm visible-md visible-lg visible-xl text-right">Стоимость, <span class="glyphicon glyphicon-rub"></span></div>
                        </div>
                    </th>
<? /*
                    <th>Дата начала</th>
                    <th>Наименование</th>
                    <th>Место проведения</th>
                    <th align="right">Стоимость, <span class="glyphicon glyphicon-rub"></span></th>
 */ ?>
                </tr>
                </thead>
                <tbody>

                <? foreach ($seminars as $seminar): ?>

                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-2 col-sm-3 col-6 "><?= $seminar['startDate'] ?></div>
                                <div class="col-md-5 col-sm-5 col-12 ">
                                    <a href="<?= Url::to(['seminar', 'id' => $seminar['id']]) ?>" class="link-leaving link">
                                        <?
                                        $title = '';
                                        if ($seminar['sertSeminar']) {
                                            $title = 'Сертифицированный';
                                        }
                                        if ($seminar['authSeminar']) {
                                            $title = 'Авторский';
                                        }
                                        echo $title . ' семинар "' . $seminar['name'] . '"';
                                        ?>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-3 col-12 hidden visible-sm visible-md visible-lg visible-xl">г. <?= $seminar['nameCity'] ?></div>
                                <div class="col-md-2 col-sm-3 col-12 hidden visible-sm visible-md visible-lg visible-xl text-right"><?= number_format($seminar['costDeposit']+$seminar['costSeminar'], 2, ',', ' ' ) ?></div>
                            </div>
                        </td>
                        <? /*
                        <td><?= $seminar['startDate'] ?></td>
                        <td>
                            <a href="<?= Url::to(['seminar', 'id' => $seminar['id']]) ?>" class="link-leaving link">
                            <?
                                $title = '';
                                if ($seminar['sertSeminar']) {
                                    $title = 'Сертифицированный';
                                }
                                if ($seminar['authSeminar']) {
                                    $title = 'Авторский';
                                }
                                echo $title . ' семинар "' . $seminar['name'] . '"';
                            ?>
                            </a>
                        </td>
                        <td><?= $seminar['nameCity'] ?></td>
                        <td align="right"><?= number_format($seminar['costDeposit']+$seminar['costSeminar'], 2, ',', ' ' ) ?></td>
 */ ?>
                    </tr>

                <? endforeach; ?>
                <? /*
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-md-2 col-sm-3 col-xs-6 ">г.Москва<div class="visible-sm">Пражская</div></div>
                            <div class="col-md-5 col-sm-5 col-xs-12 "></div>
                            <div class="col-md-3 col-sm-3 col-xs-12 hidden-sm"><i class="fa fa-subway"></i>&nbsp;Пражская</div>
                            <div class="col-md-2 col-sm-4 col-xs-12"><i class="fa fa-clock-o fa-2"></i>&nbsp;пн-вс с 10 до 22</div>
                        </div>
                    </td>
                </tr>
 */ ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
