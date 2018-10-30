<?php 
use app\bootstrap\RewriteUrl;
use app\bootstrap\InitSysten;
use app\bootstrap\InitConfig;

/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'timeZone' => 'Asia/Shanghai',
    'basePath' => dirname(__DIR__),
    'name' => 'Turen2',
    'version' => '1.0',
    'charset' => 'UTF-8',
    'sourceLanguage' => 'en-US', // 默认源语言
    'language' => 'zh-CN', // 默认当前环境使用的语言
    'bootstrap' => [
        'log',
        'devicedetect',//客户端检测
        [
            'class' => RewriteUrl::class,//url伪静态重写
        ],
        [
            'class' => InitSysten::class,//初始化环境：模板、语言、缓存
        ],
        [
            'class' => InitConfig::class,//全局配置缓存、界面缓存
        ],
    ],
    
    
    'controllerNamespace' => 'app\\modules\\web\\controllers',//默认为pc端
    //默认web pc端模板布局与默认路由设置
    'defaultRoute' => 'web/site/home', // 默认路由，后台默认首页
    'layout' => 'main', // 默认布局
    'viewPath' => '@app/themes/classic/web/views',
    'layoutPath' => '@app/themes/classic/web/layouts',//View组件中可配配置
    
    
    'modules' => [
        //前台web pc端：web
        'web' => [
            'class' => 'app\modules\web\Module',
            'controllerNamespace' => 'app\\modules\\web\\controllers',
            
            //wap端模板布局与默认路由设置
            'defaultRoute' => 'site/home', // 默认路由，后台默认首页
            'layout' => 'main', // 默认布局
            'viewPath' => '@app/themes/classic/web/views',
            'layoutPath' => '@app/themes/classic/web/layouts',//View组件中可配配置
        ],
        //前台wap手机端：wap
        'wap' => [
            'class' => 'app\modules\wap\Module',
            'controllerNamespace' => 'app\\modules\\wap\\controllers',
            
            //wap端模板布局与默认路由设置
            'defaultRoute' => 'site/home', // 默认路由，后台默认首页
            'layout' => 'main', // 默认布局
            'viewPath' => '@app/themes/classic/wap/views',
            'layoutPath' => '@app/themes/classic/wap/layouts',//View组件中可配配置
        ],
    ],
    'components' => [
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect',
        ],
        'request' => [
            'class' => 'yii\web\Request',
            'cookieValidationKey' => 'OUX1YppF-bHW9cm86EAmg4MwmBQ6Xvni',
            'csrfParam' => '_csrf-frontend',
            'enableCsrfValidation' => true,//默认显示csrf验证（前提）
            'enableCsrfCookie' => true,//默认显示了基于cookie的csrf，否则将以session传递验证数据
            'enableCookieValidation' => true,//默认配合上面启用验证
        ],
        /*
         'user' => [
             'identityClass' => 'common\models\User',
             'enableAutoLogin' => true,
             'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
         ],
         */
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'app-frontend',
        ],
        'view' => [
            // 主题配置(module目录下的views > 根目录下的views > 主题下的模板)
            'class' => 'app\components\View',
            
            //theme的功能是重新映射的关系，即将原模板系统默认的目录结果映射为自定义目录结构！！
            //默认机制是，模板目录结构与控制器挂件模块等结构保持一致。
            //'theme' => [
                //'class' => 'yii\base\Theme',
                //'basePath' => '@app/themes/classic',//主题所在文件路径
                //'baseUrl' => '@app/themes/classic',//与主题相关的url资源路径
                /*
                'pathMap' => [
                    '@app/modules' => '@app/themes/classic/modules',//模块模板
                    '@app/widgets' => '@app/themes/classic/widgets',//部件模板
                    '@app/views' => '@app/themes/classic/views',//布局模板
                ],
                */
            //]
        ],
        //前端资源管理
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            //强制更换核心资源的版本，前端兼容性考虑
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@app/assets/jquery/',
                    'js' => [
                        'jquery.min.js'//
                    ]
                ],
            ],
        ],
        //异常处理
        'errorHandler' => [
            'class' => 'yii\web\ErrorHandler',
            'errorAction' => 'site/error',//默认显示pc版路由
        ],
        /*
        //伪静态管理
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        //日志管理
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
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
