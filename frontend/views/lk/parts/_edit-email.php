<?php

/* @var $this yii\web\View */
/* @var $instructor frontend\models\Insructor */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

?>
<div id="edit-about">
    <h1>Изменение Email</h1>

    <?php
        $form = ActiveForm::begin([
            'method' => 'post',
        ]);
    ?>

    <div class="row thumbnail">
        <div class="col-11">
            <?/*= $form->field($instructor, 'about')->label(false)->widget(CKEditor::className(),  [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[]),
                ]);*/
            ?>
        </div>
        <div class="col-1 text-right">
            <?= Html::submitButton('Сохранить', [
                    'class' => 'btn btn-outline-primary',
                ])
            ?>
            <a href="<?=Url::to(['lk/index', 'tab' => 'account'])?>" class="btn btn-outline-danger">Отменить</a>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
