<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET,HEAD back/users' => 'user/index',
                'GET,HEAD back/users/<guid>/positions' => 'user/index-positions',
                'GET,HEAD back/users/<guid>/last-position' => 'user/last-position',
                'DELETE back/users/<guid>' => 'user/delete',
                'GET,HEAD back/restore-user/<guid>' => 'user/restore',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableSession' => true,
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'session', 
        ],
        'formatter' => [
            'datetimeFormat' => 'php:' . DateTime::ISO8601,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
