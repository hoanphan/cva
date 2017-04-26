<?php
use kartik\mpdf\Pdf;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$baseUrl = str_replace('/web', '', (new \yii\web\Request)->getBaseUrl());

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'setting'  => [
            'class'               => 'navatech\setting\Module',
            'controllerNamespace' => 'navatech\setting\controllers',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
	        'roxymce' => [
		        'class' => '\navatech\roxymce\Module',
		        'uploadFolder' => '@frontend/web/uploads/images',
		        'uploadUrl' => '/uploads/images',
	        ],



    ],
    'components' => [

        'request'      => [
            'baseUrl' => $baseUrl,
        ],
        'user' => [
            'identityClass' => 'backend\models\DsGiaoVien',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'suffix'          => '.html',
            'rules'           => require(__DIR__ . '/route.php'),
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => ['html' => '\yii\helpers\Html'],
                    'uses' => ['yii\bootstrap'],
                ],
                // ...
            ],
        ],

            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',

            ],


    ],
    'params' => $params,
];
