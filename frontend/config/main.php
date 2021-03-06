<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'index/index',
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
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
          //  'class' => 'frontend\components\sanUrlManager' ,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
           // 'enableSanUrl' => true ,
            //'enableStrictParsing' => false,
           // 'suffix' => '.html',
           /* 'rules' => [
                '/error' => 'site/error',
                '<cat:(a)>/?' => 'stock/index',
                '<cat:(b)>/?' => 'stock/add',
                '<cat:(c)>/?' => 'stock/edit',
                '<cat:(c)>/<id:\d+>.html/?' => 'stock/edit',
                '<code:([a-zA-Z]+[0-9]+)>' => 'detail/index',
            ],*/

        ],
    ],
    'params' => $params,
];
