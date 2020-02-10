<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-console',
	'name' => '控制台',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        //
    ],
    'controllerNamespace' => 'console\controllers',
    /*
	'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                // ...升级队列数据库数据
                'yii\queue\db\migrations',
            ],
        ],
    ],
	*/
    'components' => [
        // 本地使用25端口，tls协议。阿里等平台禁止了25，请使用465端口，ssl协议。且现在国家都在使用授权码替代密码。
        'mailer' => [// 公共发送邮件配置
            'class' => 'yii\swiftmailer\Mailer',//这个类中配置模板
            'viewPath' => '@app/mail',//邮件模板目录
            // 'view' => [], // 邮件模板同样支持yii的view模板机制，非常强大
            //开发调试用的（邮件在@runtime/mail目录下）
            'useFileTransport' => false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'fileTransportPath' => '@app/runtime/mail',//配合FileTransport，指定邮件内容的缓冲位置
            'enableSwiftMailerLogging' => true,//显示log
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'port' => '465',//465
                'encryption' => 'ssl',//tls or ssl(tls可以认为是ssl的升级版)
                'username' => 'xiayouqiao2008@163.com',
                'password' => 'kd7GGfe9fg5wfgdd',//使用授权码
            ],
            'messageConfig'=> [//这部分可以在send发邮件时临时配置
                'charset' => 'UTF-8',
                //'from'=>['' => ''],
                //'bcc' => ['aaa@163.com'=>'aaa'],//加密超送，(cc为普通超送)
            ],
        ],
    ],
    'params' => $params,
];