<?php
$config = [
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'bootstrap' => [
        //
    ],
    'components' => [
        //mysql锁机制
//        'mutex' => [
//            'class' => 'yii\mutex\MysqlMutex',
//        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',//通用的，与环境、应用都无关，全局一样
            'directoryLevel' => 2,//多层目录，提高存储效率
            'cachePath' => '@common/runtime/cache',//全局使用一套缓存目录，数据库缓存，redis，memcahced等不需要单独设置
        ],
        /*
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'db' => 'db',
            'itemTable' => '{{%sys_auth_item}}',
            'itemChildTable' => '{{%sys_auth_item_child}}',
            'assignmentTable' => '{{%sys_auth_assignment}}',
            'ruleTable' => '{{%sys_auth_rule}}',
            'cache' => 'cache',
            'cacheKey' => 'rbac',
        ],
        */
    ],
];

return $config;