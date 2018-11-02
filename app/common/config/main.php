<?php
$config = [
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'bootstrap' => [
        //'queue',//全局队列
    ],
    'components' => [
        //mysql锁机制
        /*
        'mutex' => [
            'class' => 'yii\mutex\MysqlMutex',
        ],
        */
        //队列
        /*
        'queue' => [
            //'class' => 'yii\queue\file\Queue',//队列类型
            //'path' => '@common/runtime/queue',//存储路径
            
            'class' => 'yii\queue\db\Queue',//队列类型
            'channel' => 'queue_channel',//队列通道
            'db' => 'db',//对接的数据库资源为db库
            'mutex' => 'mutex',//锁机制
            'deleteReleased' => false,//清除发布的信息
            'serializer' => 'yii\queue\serializers\JsonSerializer',//存储格式
            'ttr' => 300,//重试停留时间
            'attempts' => 1,//默认重试次数
        ],
        */
        'db' => [//线上正式环境
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=;dbname=',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => '',//前缀
            //Schema
            //'enableSchemaCache' => true,
            //'schemaCacheDuration' => 3600,
            //'schemaCache' => 'cache',//指定存储对象
            //Query
            //'enableQueryCache' => true,
            //'queryCacheDuration' => 3600,
            //'queryCache' => 'cache',//指定存储对象
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',//通用的，与环境、应用都无关，全局一样
            'directoryLevel' => 2,//多层目录，提高存储效率
            'cachePath' => '@common/runtime/cache',//全局使用一套缓存目录，数据库缓存，redis，memcahced等不需要单独设置
        ],
        'aliyunoss' => [//阿里云oss开放存储
            'class' => 'common\components\AliyunOss',
            'bucket' => '',
            'isCName' => false,
            'endpoint' => '',
            'useHttps' => false,
            'customDomain' => '',//绑定自有域名
            'accessKeyId' => '',
            'accessKeySecret' => '',
        ],
        //配置这个组件是为了console控制台应用中可以运行rbac数据库升级程序，公共配置一下，具体应用中会被覆盖
        'mailer' => [// 公共发送邮件配置
            'class' => 'yii\swiftmailer\Mailer',//这个类中配置模板
            //'viewPath' => '@common/mail',
            //开发调试用的（邮件在@runtime/mail目录下）
            'useFileTransport' => false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            //'fileTransportPath' => '@common/runtime/mail',//配合FileTransport，指定邮件内容的缓冲位置
            'enableSwiftMailerLogging' => true,//显示log
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '',
                //'encryption' => 'tls',//tls or ssl(tls可以认为是ssl的升级版)
            ],
            'messageConfig'=> [//这部分可以在send发邮件时临时配置
                'charset' => 'UTF-8',
                'from'=>['' => ''],
                //'bcc' => ['aaa@163.com'=>'aaa'],//加密超送，(cc为普通超送)
            ],
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