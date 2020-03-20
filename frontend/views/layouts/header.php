<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> :: ТетаХилинг Семинары</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 dropup">
            <img src="<?= Yii::getAlias('@images') ?>/logo.jpg" id="logo" />
            <div id="logo-name">ТетаХилинг Семинары</div>
        </div>
        <div class="col text-right mt-4" id="main-menu">
            <?
                echo Html::a('Главная', ['site/index'], [
                        'class' => 'link-leaving nav-link float-left',
                        'title' => 'Перейти на Главную страницу сайта',
                    ]);

                if (Yii::$app->user->isGuest) {
                    echo Html::a('Регистрация', ['site/signup'], [
                            'class' => 'link-leaving nav-link float-left',
                            'title' => 'Регистрация инструктора на сайте',
                        ]);
                    echo Html::beginForm(['site/logout'], 'post')
                        . Html::a('Войти в ЛК', ['site/login'], [
                            'class' => 'link-leaving nav-link',
                            'title' => 'Войти в Личный кабинет инструктора',
                        ])
                        . Html::endForm();
/*
                    echo Html::a('Войти в ЛК', ['site/login'], [
                            'class' => 'link-leaving nav-link ml-3 float-left',
                            'title' => 'Войти в Личный кабинет инструктора',
                        ]);
*/
                } else {
                    echo Html::a('Личный кабинет', ['lk/index'], [
                            'class' => 'link-leaving nav-link float-left',
                            'title' => 'Перейти в Личный кабинет инструктора',
                        ]);
                    echo Html::beginForm(['site/logout'], 'post')
                        . Html::submitButton(
                  //      'Выйти из ЛК (' . Yii::$app->user->identity->username . ')'
                        'Выйти из ЛК'
                            , ['class' => 'link-leaving nav-link', 'title' => 'Выйти из Личного кабинета инструктора']
                        )
                        . Html::endForm();
                }
            ?>

        </div>
    </div>
<? /*
    <div class="row">
        <div class="col-auto dropup">
            <img src="<?= Yii::getAlias('@images') ?>/logo.jpg" id="logo" />
            <div id="logo-name">ТетаХилинг Семинары</div>
        </div>
        <div class="col">
            <div class="row">
                <nav class="navbar navbar-expand-sm navbar-light container-fluid">

                <div class="col text-right" st  yle="border: red solid 1px">
                    <div id="btn">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                                aria-controls="navbarContent" aria-expanded="false" aria-label="Меню">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col text-right">


                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav">

                            <li>
                                <a class="link-leaving nav-link mt-2 mr-3" href="<?= Url::to(['site/index']) ?>" title="Перейти на Главную страницу сайта">Главная</a>
                            </li>

                            <?php if (Yii::$app->user->isGuest): ?>

                                <li>
                                    <a class="link-leaving nav-link mt-2 mr-3" href="<?= Url::to(['site/signup']) ?>" title="Регистрация инструктора на сайте">Регистрация</a>
                                </li>
                                <li>
                                    <a class="link-leaving nav-link mt-2 mr-3" href="<?= Url::to(['site/login']) ?>" title="Войти в Личный кабинет инструктора">Войти в ЛК</a>
                                </li>

                            <?php else: ?>

                                <li>
                                    <a class="link-leaving nav-link mt-2 mr-3" href="<?= Url::to(['lk/index']) ?>" title="Перейти в Личный кабинет инструктора">Личный кабинет</a>
                                </li>
                                <li>

                                    <?= Html::beginForm(['site/logout'], 'post')
                                            . Html::submitButton(
                                                'Выйти из ЛК (' . Yii::$app->user->identity->username . ')'
                                                , ['class' => 'link-leaving nav-link btn-logout']
                                            )
                                            . Html::endForm();
                                    ?>

                                </li>

                            <?php endif; ?>

                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </nav>
        </div>
            <!--/.navbar -->
        </div>
    </div>
 */ ?>
