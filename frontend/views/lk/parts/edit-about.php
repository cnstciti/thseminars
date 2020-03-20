<?php

/* @var $this yii\web\View */
/* @var $instructor frontend\models\Insructor */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

?>
<div id="edit-about">
    <h1 class="mt-3">Редактирование информации "Обо мне"</h1>

    <?php
        $form = ActiveForm::begin([
            'method' => 'post',
        ]);
    ?>

    <div class="row thumbnail">
        <div class="col-auto col-lg mt-3">

            <?= $form->field($instructor, 'about')->widget(CKEditor::className(),  [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[]),
                ])->label(false);
            ?>

        </div>
        <div class="col-12 col-lg-auto text-right">
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

                    <?= Html::a('Отменить', ['lk/index', 'tab'=>'about'], ['class' => 'btn btn-outline-danger btn-lg btn-block']) ?>

                </div>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
