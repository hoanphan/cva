<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'vi-VN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'setting' => [
            'class' => 'navatech\setting\Setting',
        ],
    ],
    'modules' => [
        'datecontrol' => [
            'class'           => 'kartik\datecontrol\Module',
            'displaySettings' => [
                'date'     => 'php:d-m-Y',
                'time'     => 'H:i:s A',
                'datetime' => 'd-m-Y H:i:s A',
            ],
            'saveSettings'    => [
                'date'     => 'php:Y-m-d',
                'time'     => 'H:i:s',
                'datetime' => 'Y-m-d H:i:s',
            ],
            'autoWidget'      => true,
        ],

    ],
];
