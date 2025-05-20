<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    "name" => "Mon parfum",
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '123',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'scheme' => 'smtps',
                'host' => 'smtp.mail.ru',
                'username' => 'parfumstore_info@mail.ru',
                'password' => 'scrLwiG6Ec9D7ETn3vLi',
                'port' => 465,
                // 'dsn' => 'native://default',
                // 'options' => [
                //     'ssl' => true,
                // ]
            ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                'account/profile/view' => 'account/profile/view',

            ],
        ],
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => true, // do not load bootstrap assets for a specific asset bundle
                    'bsVersion' => '5.x',
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
                'path' => 'img',
                'name' => 'Image'
            ],
            // 'watermark' => [
            // 			'source'         => __DIR__.'/logo.png', // Path to Water mark image
            // 			 'marginRight'    => 5,          // Margin right pixel
            // 			 'marginBottom'   => 5,          // Margin bottom pixel
            // 			 'quality'        => 95,         // JPEG image save quality
            // 			 'transparency'   => 70,         // Water mark image transparency ( other than PNG )
            // 			 'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
            // 			 'targetMinPixel' => 200         // Target image minimum pixel size
            // ]
        ]
    ],
    'params' => $params,
    'modules' => [
        'account' => [
            'class' => 'app\modules\account\Module',
            'defaultRoute' => 'order/index',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'order/index'
        ],
        'notes' => [
            'class' => 'app\modules\notes\Module',
            'defaultRoute' => 'notes'
        ],

        'category' => [
            'class' => 'app\modules\category\Module',
            'defaultRoute' => 'category'
        ],
        'shop' => [
            'class' => 'app\modules\shop\Module',
            'defaultRoute' => 'catalog'
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
