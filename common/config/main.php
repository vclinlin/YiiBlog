<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'urlManager' => [   //默认
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'rules' => [
//            ],
//        ],
//        'urlManager' => [   //自定义
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'suffix'=>'.jsp'
//        ],
    ],
    'modules'=>[

        'gii' => [
            'class' => 'yii\gii\Module',
            // 配置访问IP地址
            'allowedIPs' => ['127.0.0.1', '::1','61.157.243.120']
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            // 配置访问IP地址
            'allowedIPs' => ['127.0.0.1', '::1','61.157.243.120']
        ],
    ]
];
