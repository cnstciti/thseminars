<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\seminar\Seminar */
/* @var $cities frontend\models\Cities */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use frontend\models\instructor\Language;
use frontend\models\seminar\SertSeminar;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

switch ($mode) {
    case 'create':
        $nameSubmit = 'Создать';
        $title      = 'Создание семинара';
        break;
    case 'edit':
        $nameSubmit = 'Сохранить';
        $title      = 'Редактрование семинара';
        break;
    case 'copy':
        $nameSubmit = 'Скопировать';
        $title      = 'Копирование семинара';
        break;
    case 'delete':
        $nameSubmit = 'Удалить';
        $title      = 'Удаление семинара';
        break;
    case 'publish':
        $nameSubmit = 'Опубликовать';
        $title      = 'Публикация семинара';
        break;
}
?>
<div id="seminar-form">
    <h1 class="mt-3"><?= $title ?></h1>

    <?php
        $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'method' => 'post',
        ]);
    ?>

    <? if ($mode == 'publish'): ?>

        <div class="row">
            <div class="col-12 alert alert-primary" role="alert">
                <p><b>Операция публикации семинара является необратимой! После публикации редактирование информации будет недоступно!</b></p>
                <hr>
                <p>Количество семинаров для бесплатной публикации: <?= $maxPubSeminar ?> шт.</p>
                <p>Вы опубликовали: <?= $numPubSeminar ?> шт.</p>
                <p>Вы можете опубликовать: <?= $maxPubSeminar-$numPubSeminar ?> шт.</p>
                <hr>
                <p><b>Количество публикаций бесплатных семинаров (с нулевой стоимостью) - неограничено!</b></p>
            </div>
        </div>

    <? endif; ?>

    <? if ($mode == 'delete'): ?>

        <div class="row">
            <div class="col-12 alert alert-danger" role="alert">
                <p>Операция удаления семинара является необратимой! Все данные удаляются безвозвратно!</p>
            </div>
        </div>

    <? endif; ?>

    <div class="row thumbnail">
        <div class="col">
            <div class="row">
                <div class="col pl-5">
                    <div class="row">
                        <div class="col-12">
                            <label class="control-label">Наименование</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 thumbnail img-select">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 rb">
                                        <?
                                            echo $form->field($model, 'sertSeminar')->radio([
                                                'label' => 'Сертифицированный семинар',
                                                'id'    => 'radioSertSeminar',
                                            ]);
                                        ?>
                                        </div>
                                    </div>
                                    <div class="row ml-4">
                                        <div class="col">
                                        <?
                                            $url = Yii::getAlias('@logoSertSeminar');
                                            $data = (new SertSeminar)->all();

                                            $format = "
                                                function format(seminar) {
                                                    if (!seminar.id) return null;
                                                    src = '$url' + seminar.id + '.png';
                                                    return '<img class=\"logo mr-3\" src=\"' + src + '\" width=\"120\" />'
                                                        + seminar.text;
                                                }
                                            ";

                                            $escape = new JsExpression("function(m) { return m; }");
                                            $this->registerJs($format, yii\web\View::POS_HEAD);
                                            echo $form->field($model, 'name')->widget(Select2::classname(), [
                                                'name'          => 'name',
                                                'hideSearch'    => true,
                                                'data'          => $data,
                                                'options'       => [
                                                    'class' => 'mr-5',
                                                ],
                                                'pluginOptions' => [
                                                    'templateResult'    => new JsExpression('format'),
                                                    'templateSelection' => new JsExpression('format'),
                                                    'escapeMarkup'      => $escape,
                                                    'allowClear'        => true,
                                                ],
                                            ]);
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 rb">
                                        <?
                                            echo $form->field($model, 'authSeminar')->radio([
                                                'label'        => 'Авторский семинар',
                                                'id'           => 'radioAuthSeminar',
                                            ]);
                                        ?>
                                        </div>
                                    </div>
                                    <div class="row ml-4">
                                        <div class="col-12 col-sm-7 col-md-12 col-xl-7">
                                        <?
                                            $model['logo'] = Yii::getAlias('@logoAuthSeminar') . $model['logo'];
                                            echo $form->field($model, 'logo')->widget(FileInput::classname(), [
                                                'options'=>[
                                                    'multiple' => false,
                                                    'accept'   => 'image/*',
                                                    'id'       => 'logoSeminar',
                                                ],
                                                'language'      => 'ru',
                                                'pluginOptions' => [
                                                    'initialPreview' => $model['logo'] ? [Html::img($model['logo'], [
                                                            'style'  => 'width: auto; height: auto; max-width: 100%; max-height: 100%'
                                                        ]
                                                    )] : [],
                                                    'showRemove'  => false,
                                                    'showCaption' => false,
                                                    'showUpload'  => false,
                                                    'showClose'   => false,
                                                    'showCancel'  => false,
                                                    'browseClass' => 'btn-avatar btn-primary btn-block',
                                                    'browseIcon'  => '<i class="glyphicon glyphicon-camera"></i> ',
                                                    'browseLabel' => 'Выбрать изображение'
                                                ],
                                            ]);
                                        ?>

                                            <p>Ширина логотипа не должна быть менее 200 и более 300 пикселов, высота не должна быть менее 100 и более 200 пикселов. Размер логотипа не должен превышать 512 Кб.</p>

                                        </div>
                                        <div class="col-12 col-sm-5 col-md-12 col-xl-5">
                                        <?
                                            echo $form->field($model, 'name')->textInput([
                                                'value'       => $model->name,
                                                'id'          => 'name',
                                                'disabled'    => ($mode == 'delete') ? true : false,
                                                'placeholder' => 'Наименование авторского семинара',
                                                'class'       => 'form-control-lg',
                                            ]);
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md">
                    <div class="row">
                        <div class="col-12">
                        <?
                            echo $form->field($model, 'fkCityId')->widget(Select2::classname(), [
                                'data'          => $cities,
                                'disabled'      => ($mode == 'delete') ? true : false,
                                'size'          => 'sm',
                                'bsVersion'     => '4.x',
                                'theme'         => Select2::THEME_KRAJEE,
                                'options'       => [
                                    'placeholder' => 'Выберите город ...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]);

                            $model->startDate = date('d.m.Y',strtotime($model->startDate));
                            echo $form->field($model , 'startDate')->widget(DatePicker::classname(), [
                                'options'       => [
                                    'placeholder' => 'Выберите дату начала семинара ...'
                                ],
                                'disabled'      => ($mode == 'delete') ? true : false,
                                'size'          => 'lg',
                                'bsVersion'     => '4.x',
                                'type'          => DatePicker::TYPE_COMPONENT_APPEND,
                                'pluginOptions' => [
                                    'startDate'      => date("d.m.Y"),
                                    'format'         => 'dd.mm.yyyy',
                                    'todayHighlight' => true,
                                    'autoclose'      => true,
                                    'language'       => 'ru',
                                ]
                            ]);

                            echo $form->field($model, 'fkInstructorId1')->hiddenInput(['value' => $instructor['fkUserId']])->label(false);

                            echo $form->field($model, 'durationDay')->textInput([
                                'type'        => 'number',
                                'disabled'    => ($mode == 'delete') ? true : false,
                                'placeholder' => 'Введите продолжительность семинара в днях ...',
                                'class'       => 'form-control-lg',
                            ]);

                            echo $form->field($model, 'durationHour')->textInput([
                                'type'        => 'number',
                                'disabled'    => ($mode == 'delete') ? true : false,
                                'placeholder' => 'Введите продолжительность семинара в часах ...',
                                'class'       => 'form-control-lg',
                            ]);

                            echo $form->field($model, 'numberParticipants')->textInput([
                                'type'        => 'number',
                                'disabled'    => ($mode == 'delete') ? true : false,
                                'placeholder' => 'Введите количество участников семинара ...',
                                'class'       => 'form-control-lg',
                            ]);

                            echo $form->field($model, 'costDeposit')->textInput([
                                'type'        => 'number',
                                'disabled'    => ($mode == 'delete') ? true : false,
                                'placeholder' => 'Введите стоимость депозита за семинар ...',
                                'class'       => 'form-control-lg',
                            ]);

                            echo $form->field($model, 'costSeminar')->textInput([
                                'type'        => 'number',
                                'disabled'    => ($mode == 'delete') ? true : false,
                                'placeholder' => 'Введите стоимость обучения за семинар ...',
                                'class'       => 'form-control-lg',
                            ]);

                            $model->language = unserialize($model->language);
                            if ($mode == 'delete') {
                                $options = [
                                    'item' => function($index, $label, $name, $checked, $value) {
                                        return Html::checkbox($name, $checked, [
                                            'value'    => $value,
                                            'disabled' => true,
                                            'label'    => '<div class="cb mr-5">' . $label . '</div> ',
                                        ]);
                                    },
                                ];
                            } else {
                                $options = [
                                    'item' => function($index, $label, $name, $checked, $value) {
                                        return Html::checkbox($name, $checked, [
                                            'value'    => $value,
                                            'disabled' => false,
                                            'label'    => '<div class="cb mr-5">' . $label . '</div> ',
                                        ]);
                                    },
                                ];
                            }
                            echo $form->field($model, 'language')->checkboxList((new Language)->all(), $options);

                            echo $form->field($model, 'fkInstructorId2')->widget(Select2::classname(), [
                                'data'          => $instructors,
                                'disabled'      => ($mode == 'delete') ? true : false,
                                'size'          => 'sm',
                                'bsVersion'     => '4.x',
                                'theme'         => Select2::THEME_KRAJEE,
                                'options'       => [
                                    'placeholder' => 'Выберите инструктора ...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]);

                            echo $form->field($model, 'fkInstructorId3')->widget(Select2::classname(), [
                                'data'          => $instructors,
                                'disabled'      => ($mode == 'delete') ? true : false,
                                'size'          => 'sm',
                                'bsVersion'     => '4.x',
                                'theme'         => Select2::THEME_KRAJEE,
                                'options'       => [
                                    'placeholder' => 'Выберите инструктора ...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]);

                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                        'editorOptions' => [
                            ElFinder::ckeditorOptions('elfinder',[]),
                            'readOnly' => ($mode == 'delete') ? true : false,
                        ]
                    ]);
                ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12">

                <?= $form->field($model, 'schedule')->widget(CKEditor::className(), [
                        'editorOptions' => [
                            ElFinder::ckeditorOptions('elfinder',[]),
                            'readOnly' => ($mode == 'delete') ? true : false,
                        ]
                    ]);
                ?>

                </div>
            </div>
        </div>
        <div class="col-12 col-xl-auto text-right">
            <div class="row">
                <div class="col mb-4 mt-3">

                    <?= Html::submitButton($nameSubmit, [
                        'class' => 'btn btn-outline-primary btn-lg btn-block',
                    ]);
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col">

                    <?= Html::a('Отменить', ['lk/index', 'tab'=>'seminar'], ['class' => 'btn btn-outline-danger btn-lg btn-block']) ?>

                </div>
            </div>
        </div>

    </div>

<?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
    $(document).ready(function(){
        $('input[type=radio][id=\"radioSertSeminar\"]').change(function(event){
            enableSertSeminar();
        });
        $('input[type=radio][id=\"radioAuthSeminar\"]').change(function(event){
            enableAuthSeminar();
        });
    });
    if ($('input[type=radio][id=\"radioSertSeminar\"]').prop('checked') == false 
        && $('input[type=radio][id=\"radioAuthSeminar\"]').prop('checked') == false)
    {
        $('input[type=radio][id=\"radioSertSeminar\"]').prop('checked', true);
        enableSertSeminar();
    }
    if ($('input[type=radio][id=\"radioSertSeminar\"]').prop('checked') == true) {
        enableSertSeminar();
        $('input[type=text][id=\"name\"]').prop('value', '');
    }
    if ($('input[type=radio][id=\"radioAuthSeminar\"]').prop('checked') == true) {
        enableAuthSeminar();
    }
    function enableSertSeminar() {
        $('#seminar-name').prop('disabled', false);
        $('input[type=radio][id=\"radioAuthSeminar\"]').prop(\"checked\", false);
        $('#name').prop('disabled', true);
        $('#logoSeminar').prop('disabled', true);
        $('div.field-seminar-name').addClass(\"required\")
        $('div.field-name').removeClass(\"required\");
    }
    function enableAuthSeminar() {
        $('input[type=radio][id=\"radioSertSeminar\"]').prop(\"checked\", false);
        $('#seminar-name').prop('disabled', true);
        $('#name').prop('disabled', false);
        $('#logoSeminar').prop('disabled', false);
        $('div.field-name').addClass(\"required\")
        $('div.field-seminar-name').removeClass(\"required\");
    }
");

if ($mode == 'delete') {
    $this->registerJs("
        $('input[type=radio][id=\"radioSertSeminar\"]').prop('disabled', true);
        $('input[type=radio][id=\"radioAuthSeminar\"]').prop('disabled', true);
        $('#seminar-name').prop('disabled', true);
        $('#name').prop('disabled', true);
        $('#logoSeminar').prop('disabled', true);
    ");
}