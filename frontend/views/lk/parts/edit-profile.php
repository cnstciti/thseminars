<?php

/* @var $this yii\web\View */
/* @var $instructor frontend\models\profile\Instructor */

use yii\helpers\Html;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use frontend\models\instructor\Certificate;
use frontend\models\instructor\Language;

?>
<div id="edit-profile">
    <h1 class="mt-3">Редактирование профиля</h1>

    <?php
        $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'method' => 'post',
        ]);
    ?>

    <div class="row thumbnail">
        <div class="col-auto col-sm">

            <?
                echo $form->field($instructor, 'name')->textInput([
                        'autofocus'   => true,
                        'placeholder' => 'Иван Петров',
                        'class'       => 'form-control-lg',
                    ]);

                $instructor['avatar'] = Yii::getAlias('@avatarInstructor') . $instructor['avatar'];
                echo $form->field($instructor, 'avatar')->widget(FileInput::classname(), [
                        'options'=>[
                            'multiple' => false,
                            'accept'   => 'image/*'
                        ],
                        'language' => 'ru',
                        'pluginOptions' => [
                            'initialPreview' => $instructor['avatar'] ? [Html::img($instructor['avatar'], [
                                    'style' => 'width: auto; height: auto; max-width: 100%; max-height: 100%'
                                ]
                            )] : [],
                            'showRemove'  => false,
                            'showCaption' => false,
                            'showUpload'  => false,
                            'showClose'   => false,
                            'showCancel'  => false,
                            'browseClass' => 'btn-avatar btn-primary btn-block mt-2',
                            'browseIcon'  => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' => 'Выбрать изображение'
                        ],
                ]);
            ?>

            <p>Ширина и высота фотографии не должна быть более 500 пикселов и менее 100 пикселов. Размер фотографии не должен превышать 512 Кб.</p>
        </div>

        <div class="col-12 col-md">
            <div class="col">

            <?
                $options = [
                    'item' => function($index, $label, $name, $checked, $value) {
                        return Html::checkbox($name, $checked, [
                            'value' => $value,
                            'label' => '<div class="cb mr-5">' . $label . '</div> ',
                        ]);
                    },
                ];

                $instructor['certificate'] = unserialize($instructor['certificate']);
                echo $form->field($instructor, 'certificate')->checkboxList((new Certificate)->all(), $options);

                $instructor['language'] = unserialize($instructor['language']);
                echo $form->field($instructor, 'language')->checkboxList((new Language)->all(), $options);

                echo $form->field($instructor, 'phone')->textInput([
                        'placeholder' => '+7 914 478-5261',
                        'class'       => 'form-control-lg',
                    ]);

                echo $form->field($instructor, 'email')->textInput([
                        'placeholder' => 'user@example.com',
                        'class'       => 'form-control-lg',
                    ]);
            ?>

                <label class="control-label">Мессенджеры</label>
                <div class="row">
                    <img src="<?= Yii::getAlias('@social').'skype.png' ?>" class="ml-3" title="Skype" alt="Skype" />
                    <div class="col">

                        <?= $form->field($instructor, 'profileSkype')->textInput([
                                'placeholder' => 'th-seminar',
                                'class'       => 'form-control-lg mt-3',
                            ])->label(false) ?>

                    </div>
                </div>
                <div class="row">
                    <img src="<?= Yii::getAlias('@social').'viber.png' ?>" class="ml-3" title="Viber" alt="Viber" />
                    <div class="col">

                        <?= $form->field($instructor, 'profileViber')->textInput([
                                'placeholder' => 'th-seminar',
                                'class'       => 'form-control-lg mt-3',
                            ])->label(false) ?>

                    </div>
                </div>
                <div class="row">
                    <img src="<?= Yii::getAlias('@social').'ws.png' ?>" class="ml-3" title="WhatsApp" alt="WhatsApp" />
                    <div class="col">

                        <?= $form->field($instructor, 'profileWs')->textInput([
                                'placeholder' => 'th-seminar',
                                'class'       => 'form-control-lg mt-3',
                            ])->label(false) ?>

                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-lg">
            <div class="col">

                <?= $form->field($instructor, 'www')->textInput([
                        'placeholder' => 'www.th-seminar.ru',
                        'class'       => 'form-control-lg',
                    ]);
                ?>

                <div class="img-input">
                    <label class="control-label">Личный профиль в социальных сетях</label>
                    <div class="row">
                        <div class="col-auto">
                            <img src="<?= Yii::getAlias('@social').'fb.png' ?>" title="facebook.com" alt="facebook.com" />
                        </div>
                        <div class="col">

                            <?= $form->field($instructor, 'profileFb')->textInput([
                                    'placeholder' => 'https://facebook.com/th-seminar',
                                    'class'       => 'form-control-lg mt-3',
                                ])->label(false) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <img src="<?= Yii::getAlias('@social').'ig.png' ?>" title="instagram.com" alt="instagram.com" />
                        </div>
                        <div class="col">

                            <?= $form->field($instructor, 'profileIg')->textInput([
                                    'placeholder' => 'https://www.instagram.com/th-seminar',
                                    'class'       => 'form-control-lg mt-3',
                                ])->label(false) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <img src="<?= Yii::getAlias('@social').'ok.png' ?>" title="ok.ru" alt="ok.ru" />
                        </div>
                        <div class="col">

                            <?= $form->field($instructor, 'profileOk')->textInput([
                                    'placeholder' => 'https://ok.ru/profile/575923920446',
                                    'class'       => 'form-control-lg mt-3',
                                ])->label(false) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <img src="<?= Yii::getAlias('@social').'tw.png' ?>" title="twitter.com" alt="twitter.com" />
                        </div>
                        <div class="col">

                            <?= $form->field($instructor, 'profileTw')->textInput([
                                    'placeholder' => 'https://twitter.com/th-seminar',
                                    'class'       => 'form-control-lg mt-3',
                                ])->label(false) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <img src="<?= Yii::getAlias('@social').'vk.png' ?>" title="vk.com" alt="vk.com" />
                        </div>
                        <div class="col">

                            <?= $form->field($instructor, 'profileVk')->textInput([
                                    'placeholder' => 'https://vk.com/pages?id=7891265',
                                    'class'       => 'form-control-lg mt-3',
                                ])->label(false) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <img src="<?= Yii::getAlias('@social').'yt.png' ?>" title="youtube.com" alt="youtube.com" />
                        </div>
                        <div class="col">

                            <?= $form->field($instructor, 'profileYt')->textInput([
                                    'placeholder' => 'https://www.youtube.com/channel/th-seminar',
                                    'class'       => 'form-control-lg mt-3',
                                ])->label(false) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <img src="<?= Yii::getAlias('@social').'th.png' ?>" title="thetahealing.com" alt="thetahealing.com" />
                        </div>
                        <div class="col">

                            <?= $form->field($instructor, 'profileTh')->textInput([
                                    'placeholder' => 'https://www.thetahealing.com/',
                                    'class'       => 'form-control-lg mt-3',
                                ])->label(false) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-12 col-xl-auto text-right">
            <div class="row">
                <div class="col mb-4 mt-3">

                <?= Html::submitButton('Сохранить', [
                        'class' => 'btn btn-outline-primary btn-lg btn-block',
                    ]);
                ?>

                </div>
            </div>
            <div class="row">
                <div class="col">

                <?= Html::a('Отменить', ['lk/index'], ['class' => 'btn btn-outline-danger btn-lg btn-block']) ?>

                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
