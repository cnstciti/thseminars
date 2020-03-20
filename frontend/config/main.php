<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'Семинары Тета Хилинг',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'class'               => 'yii\web\UrlManager',
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'suffix' => '/',
            'rules' => [
                //'signup' => 'site/signup',
                'seminar/<id:\d+>' => 'site/seminar',
                //'instructor' => 'site/instructor',
                //'<action:\w+>' => 'site/<action>',
                '/' => 'site/index',
            ],
        ],
        /*
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'city/' => 'lin/city',
                'sitemap/' => 'lin/sitemap',
                '<city>/' => 'lin/index',
                '/' => 'lin/index',
                '<city>/lenses/<type:\w+>/page<page:\d+>/' => 'lin/lenses',
                '<city>/means/<type:\w+>/page<page:\d+>/' => 'lin/means',
                '<city>/brand/<type>/page<page:\d+>/' => 'lin/brands',
                '<city>/maker/<type>/page<page:\d+>/' => 'lin/makers',
                '<city>/product/<prod>/' => 'lin/card',
                '<city>/brands/' => 'lin/all-brands',
                '<city>/makers/' => 'lin/all-makers',
                'shop/<page>/' => 'lin/shop',
            ],
        ],
        */
    ],
    'controllerMap' => [
        'elfinder' => [
            'class'  => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root'   => [
                'class' => 'mihaildev\elfinder\volume\UserPath',
                'path'  => 'images/upload/user_{id}',
                'name'  => 'Мои изображения'
             ],
        ]
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            //'bsVersion' => '4.x',
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    'params' => $params,
];
