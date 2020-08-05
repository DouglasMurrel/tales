<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$mail = require __DIR__ . '/mail.php';

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xxuD4AlLuCLj5LVleivm3CDBRNSHKJMh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\DB\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => $mail,
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'help/rules' => 'site/rules',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'register' => 'site/register',
                'recover' => 'site/recover',
                'reset/<hash>/<email>' => 'site/reset',
                'create' => 'game/create',
                'gettags' => 'game/gettags',
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vk' => [
//https://vk.com/editapp?id=7314194&section=options
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '7314194',
                    'clientSecret' => 'hYRHYOwT5xUfZ5ho2NKP',
                ],
                'fb' => [
//https://developers.facebook.com/apps/635474197229734/fb-login/settings/
                    'class' => '\yii\authclient\clients\Facebook',
                    'clientId' => '635474197229734',
                    'clientSecret' => 'ae61ea9de70a6423f06341a7476f6359',
                ],
                'yandex' => [
//https://oauth.yandex.ru/client/9b4d94f57e5f4e62ba57b3c7b31185b3
                    'class' => '\yii\authclient\clients\Yandex',
                    'clientId' => '9b4d94f57e5f4e62ba57b3c7b31185b3',
                    'clientSecret' => '3652564f0e1f4c5785e5959d334ce4ca',
                ],
                'google' => [
//https://console.developers.google.com/apis/credentials?project=tales-268020
                    'class' => '\yii\authclient\clients\Google',
                    'clientId' => '871857629159-orgquacs24arnr0oo8mlk9a2b7cj187d.apps.googleusercontent.com',
                    'clientSecret' => 'xK-xU5H21JNJJUaoCEMj83rM',
                ],
                // etc.
            ],
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
