<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    //require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
    //require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => dirname(__DIR__),
    'name' => 'Turen',
    'version' => '1.0',
    'charset' => 'UTF-8',
    'sourceLanguage' => 'en-US', // 默认源语言
    'language' => 'zh-CN', // 默认当前环境使用的语言
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\\modules\\common\\controllers',
    'defaultRoute' => 'common/site/index', // 默认路由，后台默认首页
    'layout' => 'main', // 默认布局
    'viewPath' => '@app/themes/classic',
    'layoutPath' => '@app/themes/classic/layouts',//View组件中可配配置

    'modules' => [
        'invest' => [
            'class' => 'app\modules\invest\Module',
        ],
    ],
    'components' => [
        'request' => [
                'class' => 'yii\web\Request',
                'cookieValidationKey' => 'OUX1YppF-bHW9cm86EAmg4MwmBQ6Xvni',
                'csrfParam' => '_csrf-frontend',
                'enableCsrfValidation' => true,//默认显示csrf验证（前提）
                'enableCsrfCookie' => true,//默认显示了基于cookie的csrf，否则将以session传递验证数据
                'enableCookieValidation' => true,//默认配合上面启用验证
            ],
        'view' => [
            'theme' => [
                'class' => 'yii\base\Theme',
                'basePath' => '@app/themes/classic',//主题所在文件路径
                'baseUrl' => '@app/themes/classic',//与主题相关的url资源路径
                'pathMap' => [
                    '@app/modules' => '@app/themes/classic/modules',//模板
                    '@app/widgets' => '@app/themes/classic/widgets',//部件
                    '@app/views' => '@app/themes/classic',//布局
                ],
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        // 'errorHandler' => [
        //     'errorAction' => 'site/error',
        // ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
