<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "https://use.fontawesome.com/releases/v5.3.1/css/all.css",
        "https://fonts.googleapis.com/css?family=Nunito|Rubik&display=swap",
    ];
//    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
//        https://code.jquery.com/jquery-3.2.1.slim.min.js
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
//        'https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];


}
