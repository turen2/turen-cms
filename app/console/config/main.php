<?php

//$params = array_merge(
//    require(__DIR__ . '/params.php')
//);

$params = require(__DIR__ . '/params.php');

return [
    'id' => 'app-console',
	'name' => '控制台',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'jialebangMailQueue',//邮件队列
        'jialebangSmsQueue',//短信队列
    ],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        // ...
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                // ...升级队列数据库数据
                'yii\queue\db\migrations',
            ],
        ],
    ],
    'components' => [
        //家乐邦邮箱队列
        'jialebangMailQueue' => [
            //'class' => 'yii\queue\file\Queue',//文件类型队列
            //'path' => '@app/runtime/queue',//文件存储路径
            'class' => 'yii\queue\db\Queue',//队列类型
            'channel' => 'jialebang_mail_channel',//队列通道
            'db' => 'db',//对接的数据库资源为db库
            'tableName' => '{{%queue}}', // Table name
            'mutex' => 'yii\mutex\MysqlMutex',//锁机制
            'deleteReleased' => false,//清除发布的信息
            'serializer' => 'yii\queue\serializers\JsonSerializer',//存储格式
            'ttr' => 10,//重试停留时间
            'attempts' => 4,//默认重试次数
            'as log' => \yii\queue\LogBehavior::class,//错误日志 默认为 console/runtime/logs/app.log
        ],
        //家乐邦短信队列
        'jialebangSmsQueue' => [
            //'class' => 'yii\queue\file\Queue',//文件类型队列
            //'path' => '@app/runtime/queue',//文件存储路径
            'class' => 'yii\queue\db\Queue',//队列类型
            'channel' => 'jialebang_sms_channel',//队列通道
            'db' => 'db',//对接的数据库资源为db库
            'tableName' => '{{%queue}}', // Table name
            'mutex' => 'yii\mutex\MysqlMutex',//锁机制
            'deleteReleased' => false,//清除发布的信息
            'serializer' => 'yii\queue\serializers\JsonSerializer',//存储格式
            'ttr' => 10,//重试停留时间
            'attempts' => 4,//默认重试次数
            'as log' => \yii\queue\LogBehavior::class,//错误日志 默认为 console/runtime/logs/app.log
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',//通用的，与环境、应用都无关，全局一样
            'directoryLevel' => 2,//多层目录，提高存储效率
            'cachePath' => '@app/runtime/cache',//全局使用一套缓存目录，数据库缓存，redis，memcahced等不需要单独设置
        ],
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