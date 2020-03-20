<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\instructor\Language;
use kartik\grid\GridView;
use kartik\bs4dropdown\ButtonDropdown;

$this->registerCssFile('yii/npm-asset/bootstrap/dist/css/bootstrap.css', ['depends' => ['frontend\assets\AppAsset']]);

/* @var $this yii\web\View */
/* @var $searchModel app\models\SeminarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*
if (!empty($seminars->allModels)) {
$gridColumns = [
    [
        'header' => 'Дата начала',
        'value'  => 'startDate',
    ],
    [
        'header'  => 'Наименование',
        'content' => function($data) {
            if ($data['sertSeminar']) {
                return 'Сертифицированный семинар "' . $data['name'] . '"';
            }
            if ($data['authSeminar']) {
                return 'Авторский семинар "' . $data['name'] . '"';
            }
            return '[Ошибка в определении наименования]';
        }
    ],
    [
        'header' => 'Место проведения',
        'value'  => 'cityName',
    ],
    [
        'header'  => 'Общая стоимость',
        'hAlign'  => GridView::ALIGN_RIGHT,
        'content' => function($data) {
            return number_format($data['costDeposit']+$data['costSeminar'], 2, ',', ' ' );
        },
    ],
    [
        'header' => 'Продолжительность, в днях',
        'value'  => 'durationDay',
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'header' => 'Продолжительность, в часах',
        'value'  => 'durationHour',
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'header' => 'Количество участников',
        'value'  => 'numberParticipants',
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'header'  => 'Язык преподавания',
        'content' => function($data) {
            return implode(', ', (new Language())->selected(unserialize($data['language'])));
        }
    ],
    [
        'header'  => 'Стоимость депозита',
        'hAlign'  => GridView::ALIGN_RIGHT,
        'content' => function($data) {
            return number_format($data['costDeposit'], 2, ',', ' ' );
        },
    ],
    [
        'header'  => 'Стоимость семинара',
        'hAlign'  => GridView::ALIGN_RIGHT,
        'content' => function($data) {
            return number_format($data['costSeminar'], 2, ',', ' ' );
        },
    ],
    [
        'label'  => 'Действия',
        'format' => 'raw',
        'value'  => function ($row) {
            $items = [];
            if ($row['publish']) {
                $items[] = [
                    'label' => 'Скопировать',
                    'url'   => Url::to(['lk/copy-seminar', 'id' => $row['id']]),
                ];
                $items[] = [
                    'label' => 'Удалить',
                    'url'   => Url::to(['lk/delete-seminar', 'id' => $row['id']]),
                ];
            } else {
                $items[] = [
                    'label' => 'Редактировать',
                    'url'   => Url::to(['lk/edit-seminar', 'id' => $row['id']]),
                ];
                $items[] = [
                    'label' => 'Скопировать',
                    'url'   => Url::to(['lk/copy-seminar', 'id' => $row['id']]),
                ];
                $items[] = [
                    'label' => 'Удалить',
                    'url'   => Url::to(['lk/delete-seminar', 'id' => $row['id']]),
                ];
                $items[] = [
                    'label' => 'Опубликовать',
                    'url'   => Url::to(['lk/publish-seminar', 'id' => $row['id']]),
                ];
            }
            return ButtonDropdown::widget([
                'label'         => 'Действия',
                'buttonOptions' => ['class' => 'btn-outline-secondary'],
                'dropdown'      => [
                    'items' => $items,
                ],
                //'options' => ['class' => 'dropup'],
            ]);
        },
    ],
];
*/
?>
<div id="lk-seminars">
    <div class="row thumbnail pt-3">
        <div class="col">
            <div class="row">
                <div class="col text-right">

                    <?= Html::a('Создать семинар', ['lk/create-seminar'], ['class' => 'btn btn-outline-success btn-lg']) ?>

                </div>
            </div>
            <div class="row">
                <table class="table tbl mt-4">
                    <thead>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-12 col-sm-2 col-md-2">Дата начала</div>
                                <div class="col-12 col-sm-7 col-md-5">Наименование</div>
                                <div class="col-md-1 hidden visible-md visible-lg visible-xl">Место проведения</div>
                                <div class="col-sm-2 col-md-2 hidden visible-sm visible-md visible-lg visible-xl text-right">Стоимость, <span class="glyphicon glyphicon-rub"></span></div>
                                <div class="col-12 col-sm-1 col-md-1 text-right"></div>
                            </div>
                        </th>
                        <? /*
                        <th>Дата начала</th>
                        <th>Наименование</th>
                        <th>Место проведения</th>
                        <th align="right">Стоимость, <span class="glyphicon glyphicon-rub"></span></th>
                        <th></th>
 */ ?>
                    </tr>
                    </thead>
                    <tbody>

                    <? foreach ($seminars as $seminar): ?>

                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-12 col-sm-2 col-md-2"><?= $seminar['startDate'] ?></div>
                                    <div class="col-12 col-sm-7 col-md-5">
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
                                    <div class="col-md-1 hidden visible-md visible-lg visible-xl">г. <?= $seminar['nameCity'] ?></div>
                                    <div class="col-sm-2 col-md-2 hidden visible-sm visible-md visible-lg visible-xl text-right"><?= number_format($seminar['costDeposit']+$seminar['costSeminar'], 2, ',', ' ' ) ?></div>
                                    <div class="col-12 col-sm-1 col-md-1 text-right">
                                    <?
                                        $items = [];
                                        if ($seminar['publish']) {
                                            $items[] = [
                                                'label' => 'Скопировать',
                                                'url'   => Url::to(['lk/copy-seminar', 'id' => $seminar['id']]),
                                            ];
                                            $items[] = [
                                                'label' => 'Удалить',
                                                'url'   => Url::to(['lk/delete-seminar', 'id' => $seminar['id']]),
                                            ];
                                        } else {
                                            $items[] = [
                                                'label' => 'Редактировать',
                                                'url'   => Url::to(['lk/edit-seminar', 'id' => $seminar['id']]),
                                            ];
                                            $items[] = [
                                                'label' => 'Скопировать',
                                                'url'   => Url::to(['lk/copy-seminar', 'id' => $seminar['id']]),
                                            ];
                                            $items[] = [
                                                'label' => 'Удалить',
                                                'url'   => Url::to(['lk/delete-seminar', 'id' => $seminar['id']]),
                                            ];
                                            $items[] = [
                                                'label' => 'Опубликовать',
                                                'url'   => Url::to(['lk/publish-seminar', 'id' => $seminar['id']]),
                                            ];
                                        }
                                    ?>

                                    <?= ButtonDropdown::widget([
                                            'label'         => 'Действия',
                                            'buttonOptions' => ['class' => 'btn btn-outline-info btn-lg'],
                                            'dropdown'      => [
                                                'items' => $items,
                                            ],
                                            'options' => ['class' => 'drd'],
                                        ]);
                                     ?>
                                    </div>
                                </div>
                            <? /*
                        <tr>
                            <td><?= $seminar['startDate'] ?></td>
                            <td>
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
                            </td>
                            <td><?= $seminar['nameCity'] ?></td>
                            <td align="right"><?= number_format($seminar['costDeposit']+$seminar['costSeminar'], 2, ',', ' ' ) ?></td>

                            <?
                                $items = [];
                                if ($seminar['publish']) {
                                    $items[] = [
                                        'label' => 'Скопировать',
                                        'url'   => Url::to(['lk/copy-seminar', 'id' => $seminar['id']]),
                                    ];
                                    $items[] = [
                                        'label' => 'Удалить',
                                        'url'   => Url::to(['lk/delete-seminar', 'id' => $seminar['id']]),
                                    ];
                                } else {
                                    $items[] = [
                                        'label' => 'Редактировать',
                                        'url'   => Url::to(['lk/edit-seminar', 'id' => $seminar['id']]),
                                    ];
                                    $items[] = [
                                        'label' => 'Скопировать',
                                        'url'   => Url::to(['lk/copy-seminar', 'id' => $seminar['id']]),
                                    ];
                                    $items[] = [
                                        'label' => 'Удалить',
                                        'url'   => Url::to(['lk/delete-seminar', 'id' => $seminar['id']]),
                                    ];
                                    $items[] = [
                                        'label' => 'Опубликовать',
                                        'url'   => Url::to(['lk/publish-seminar', 'id' => $seminar['id']]),
                                    ];
                                }
                            ?>

                            <td align="right">

                            <?= ButtonDropdown::widget([
                                    'label'         => 'Действия',
                                    'buttonOptions' => ['class' => 'btn btn-outline-info btn-lg'],
                                    'dropdown'      => [
                                        'items' => $items,
                                    ],
                                    'options' => ['class' => 'drd'],
                                ]);
                            ?>

                            </td>
                        </tr>
 */ ?>
                        </tr>

                    <? endforeach; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

