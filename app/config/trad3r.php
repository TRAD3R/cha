<?php

use App\Mail\SmtpTransport;
use yii\db\Connection;
use yii\log\EmailTarget;
use yii\log\FileTarget;
use yii\swiftmailer\Mailer;

$params = is_file(dirname(__DIR__ ) . '/config/trad3r_params_local.php') ?
    \yii\helpers\ArrayHelper::merge(
        require dirname(__DIR__) . '/config/trad3r_params.php',
        require dirname(__DIR__) . '/config/trad3r_params_local.php'
    ) :
    require dirname(__DIR__) . '/config/trad3r_params.php';

$config = [
    'components' => [
        'mailer'      => [
            'class'            => Mailer::class,
            'useFileTransport' => false,
            'transport' => [
                'class' => SmtpTransport::class,
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => EmailTarget::class,
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'from' => ['log@trad3r'],
                        'to'   => [$params['emails']['manager']]
                    ]
                ],
            ]
        ],
        'db' => [
            'class'                 => Connection::class,
            'dsn'                   => 'mysql:host=sql18.your-server.de;dbname=db_cha_de',
            'username'              => 'riseys_7',
            'password'              => 'Hhg7xLQnuMxtHACG',
            'charset'               => 'utf8',
            'tablePrefix'           => '',
        ]
    ],
    'params' => $params
];

return $config;