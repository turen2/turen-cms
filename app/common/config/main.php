<?php
$config = [
    // 如果想要独立于yii2之外的前端框架时，请重新设置此目录
    'aliases' => [
        // '@bower' => '@vendor/bower-asset',
        // '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'Asia/Shanghai',
    'version' => '2.0.0',
    'charset' => 'UTF-8',
    'sourceLanguage' => 'en-US', // 默认源语言
    'language' => 'zh-CN', // 默认当前环境使用的语言
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'bootstrap' => [
        'log',
        'mailQueue',//邮件队列
        'smsQueue',//短信队列
    ],
    'components' => [
        //mysql锁机制
//        'mutex' => [
//            'class' => 'yii\mutex\MysqlMutex',
//        ],
        'db' => [//本地环境
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=turen_cms',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => 'ss_',//前缀
            /*
            //Schema
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',//指定存储对象
            //Query
            'enableQueryCache' => true,
            'queryCacheDuration' => 3600,
            'queryCache' => 'cache',//指定存储对象
            */
        ],
        'aliyunoss' => [//阿里云oss开放存储
            'class' => 'common\components\AliyunOss',
            'bucket' => 'yaqiao',
            'isCName' => false,
            'endpoint' => 'oss-cn-shenzhen.aliyuncs.com', // 'oss-cn-shenzhen-internal.aliyuncs.com' 这个只读，不上传，省流量
            'useHttps' => false,
            'customDomain' => 'img888.hbyaqiao.com',//绑定自有域名
            'accessKeyId' => 'LTAI4FivqoLXtfGo4YSJK1FB',
            'accessKeySecret' => 'F4Qbtwh6q1rUG8oAaJrbBTaCyvY73b',
        ],
        'sms' => [
            'class' => 'common\components\AliyunSms',
            'accessKeyId' => 'LTAI4FivqoLXtfGo4YSJK1FB',
            'accessKeySecret' => 'F4Qbtwh6q1rUG8oAaJrbBTaCyvY73b',
        ],
        //短信队列
        'smsQueue' => [
            //'class' => 'yii\queue\file\Queue',//文件类型队列
            //'path' => '@app/runtime/queue',//文件存储路径
            'class' => 'yii\queue\db\Queue',//队列类型
            'channel' => 'sms_channel',//队列通道
            'db' => 'db',//对接的数据库资源为db库
            'tableName' => '{{%queue}}', // Table name
            'mutex' => 'yii\mutex\MysqlMutex',//锁机制
            'deleteReleased' => false,//清除发布的信息
            'serializer' => 'yii\queue\serializers\JsonSerializer',//存储格式
            'ttr' => 10,//重试停留时间
            'attempts' => 5,//默认重试次数
            'as log' => 'yii\queue\LogBehavior',//错误日志 默认为 console/runtime/logs/app.log
        ],
        /*
        'msg' => [
            'class' => 'common\components\AliyunMsg',
            'accessKeyId' => 'LTAIkRLpfMVeKOes',
            'accessKeySecret' => 'sfLejz73JL9FKOD7ucZa4su7nnHlkK',
        ],
        */
        //邮箱队列
        'mailQueue' => [
            //'class' => 'yii\queue\file\Queue',//文件类型队列
            //'path' => '@app/runtime/queue',//文件存储路径
            'class' => 'yii\queue\db\Queue',//队列类型
            'channel' => 'mail_channel',//队列通道
            'db' => 'db',//对接的数据库资源为db库
            'tableName' => '{{%queue}}', // Table name
            'mutex' => 'yii\mutex\MysqlMutex',//锁机制
            'deleteReleased' => false,//清除发布的信息
            'serializer' => 'yii\queue\serializers\JsonSerializer',//存储格式
            'ttr' => 10,//重试停留时间
            'attempts' => 5,//默认重试次数
            'as log' => 'yii\queue\LogBehavior',//错误日志 默认为 console/runtime/logs/app.log
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',//通用的，与环境、应用都无关，全局一样
            'directoryLevel' => 2,//多层目录，提高存储效率
            'cachePath' => '@common/runtime/cache',//全局使用一套缓存目录，数据库缓存，redis，memcahced等不需要单独设置
        ],
        'log' => [// 不同等级的日志，以不同的方式发给不同的人
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
            /*
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',//发送的Target对象
                    'levels' => ['error', 'warning'],//info可以在开发时做性能优化
                ],
                [
                    'class' => 'yii\log\EmailTarget',//发送邮件
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'from' => ['xiayouqiao@turen.com'],
                        'to' => ['980522557@qq.com', '19146400@qq.com'],
                        'subject' => '您有一个新bug，来自admin.turen.com',
                    ],
                ],
                [
                    'class' => 'yii\log\DbTarget',//使用数据库记录日志（注意：还可以将文件日志迁移到数据库）
                    'levels' => ['info', 'error', 'warning']
                ]
            ],
            */
        ],
        // 强制使用，本地化不跟着语言环境走
        'formatter' => [
            // 处理本地化格式，包括时间、货币、语言习惯
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Asia/Shanghai', // 上海时间（app默认也有个时区，被覆盖）
            'defaultTimeZone' => 'UTC', // 使用协调世界时
            'nullDisplay' => 0,//未设置时的默认值
            // 'dateFormat' => 'short',
            // 'timeFormat' => 'short',
            // 'datetimeFormat' => 'short'
            // currencyCode
        ],
        /*
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '2ca982b60ad643e3.redis.rds.aliyuncs.com',
            'port' => 6379,
            'password' => 'SiSabpt530560',
            'database' => 9,
        ],
        */
        /*
        'memcache' => [// memcache缓存，也可以使用其它的存储驱动，也可以改写组件id，如cache1同时启用多个不同类型的驱动
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost1',
                    'port' => 11211,
                    'weight' => 40,
                ], [
                    'host' => 'localhost2',
                    'port' => 11211,
                    'weight' => 60,
                ],
            ],
        ],
        */
        //第三方登录
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'qq' => [
                    'class' => 'common\components\oauth\QQAuth',
                    'id' => 'qq',
                    'clientId' => '101829909',
                    'clientSecret' => 'a8b43d498b42a53fac485179c98dbc49',
                    /*
                     * 不启动界面对象
                    'viewOptions' => [
                        'widget' => [
                            'class' => 'common\components\oauth\item\AuthItem',
                        ],
                        'popupWidth' => 627,
                        'popupHeight' => 400,
                    ],
                    */
                ],
                'weibo' => [
                    'class' => 'common\components\oauth\WeiboAuth',
                    'id' => 'weibo',
                    'clientId' => '114827712',
                    'clientSecret' => 'a9e489ad4fedb430d988e20f37fd8e38',
                    /*
                    'viewOptions' => [
                        'widget' => [
                            'class' => 'common\components\oauth\item\AuthItem',
                        ],
                        'popupWidth' => 627,
                        'popupHeight' => 400,
                    ],
                    */
                ],
//                'weixin' => [
//                    'class' => 'common\components\oauth\WeixinAuth',
//                    'id' => 'wx',
//                    'clientId' => '111',
//                    'clientSecret' => '111',
                    /*
                    'viewOptions' => [
                        'widget' => [
                            'class' => 'common\components\oauth\item\AuthItem',
                        ],
                        'popupWidth' => 627,
                        'popupHeight' => 400,
                    ],
                    */
//                ],
                /*
                'weixin-mp' => [
                    'class' => 'common\components\oauth\WeixinMpAuth',
                    'id' => 'wxp',
                    'clientId' => '111',
                    'clientSecret' => '111',
                    'viewOptions' => [
                        'widget' => [
                            'class' => 'common\components\oauth\item\AuthItem',
                        ],
                        'popupWidth' => 627,
                        'popupHeight' => 400,
                    ],
                ],
                */
            ]
        ],
    ],
];

return $config;