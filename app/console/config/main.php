<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    //require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
    //require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
	'name' => '控制台',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        // ...
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                // ...
                'yii\queue\db\migrations',
            ],
        ],
    ],
    'components' => [
        'db' => [//本地环境
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=turen_cms',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => 'ss_',//前缀
            //Schema
            //'enableSchemaCache' => true,
            //'schemaCacheDuration' => 3600,
            //'schemaCache' => 'cache',//指定存储对象
            //Query
            //'enableQueryCache' => true,
            //'queryCacheDuration' => 3600,
            //'queryCache' => 'cache',//指定存储对象
        ],
//        'redis' => [
//            'class' => 'yii\redis\Connection',
//            'hostname' => '2ca982b60ad643e3.redis.rds.aliyuncs.com',
//            'port' => 6379,
//            'password' => 'SiSabpt530560',
//            'database' => 9,
//        ],
        'formatter' => [
            // 处理本地化格式，包括时间、货币、语言习惯
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Asia/Shanghai', // 上海时间（app默认也有个时区，被覆盖）
            'defaultTimeZone' => 'UTC', // 使用协调世界时
            'nullDisplay' => 0,//未设置时的默认值
            'dateFormat' => 'short',
            'timeFormat' => 'short',
            'datetimeFormat' => 'short'
            // currencyCode
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
