<?php
$this->beginContent('@app/views/layouts/header.php');
$this->endContent();

use common\widgets\Alert;
use yii\widgets\Breadcrumbs;
?>

<?if( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-info alert-dismissible mt-4 mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif;?>

    <div class="container-fluid mb-5" id="content">
        <?/*= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Главная', 'url' => ['index']],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options' => [
                'class' => 'breadcrumb',
            ],
//                    'itemTemplate' => "<li><span>{link}<span></li>\n",
//'activeItemTemplate' => "<li class=\"current\" style=\"border:1px solid #b2b2b2;\">{link}</li>\n"
        ])*/ ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

<?php
$this->beginContent('@app/views/layouts/footer.php');
$this->endContent();
$this->endPage();
