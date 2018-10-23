<?php
$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'local=secret=key',
        ],
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
        'aliyunoss' => [//阿里云oss开放存储
            'class' => 'common\components\aliyunoss\AliyunOss',
            'bucket' => '',
            'isCName' => false,
            'endpoint' => '',
            'useHttps' => false,
            'customDomain' => '',//绑定自有域名
            'accessKeyId' => '',
            'accessKeySecret' => '',
        ],
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
    ],
];

return $config;