<?php
return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@mysite' => 'http://th2.my/frontend/web',
        '@images' => '@mysite/images',
        '@logoSertSeminar' => '@images/sert_seminar/',
        '@logoAuthSeminar' => '@images/auth_seminar/',
        '@logoAuthWWW' => 'E:\OSPanel\domains\th2.my\frontend\web\images\auth_seminar',
        '@social' => '@images/social/',
        '@avatarInstructor' => '@images/avatar/',
        '@avatarInstructorWWW' => 'E:\OSPanel\domains\th2.my\frontend\web\images\avatar',
        '@uploadUser' => 'E:\OSPanel\domains\th2.my\frontend\web\images\upload\user_',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];