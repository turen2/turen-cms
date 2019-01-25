<?php 
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use app\bootstrap\Init;

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
    'name' => 'Jialebang',
    'version' => '1.0',
    'charset' => 'UTF-8',
    'sourceLanguage' => 'en-US', // 默认源语言
    'language' => 'zh-CN', // 默认当前环境使用的语言
    'controllerNamespace' => 'app\controllers',
    'defaultRoute' => 'site/home',//'banjia/home/default', // 默认路由，后台默认首页
    'layout' => 'main', // 默认布局
    'bootstrap' => [
        'log',
        'devicedetect',//客户端检测
        [
            'class' => Init::class,//初始化环境：模板、语言、缓存
        ],
    ],
    'modules' => [
        //搬家模块
        'banjia' => [
            'class' => 'app\modules\banjia\Module',
        ],
        //用户中心模块
        'member' => [
            'class' => 'app\modules\member\Module',
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
            'theme' => [
                'class' => 'yii\base\Theme',//配置了才能初始化
            ],
            //theme的功能是重新映射的关系，即将原模板系统默认的目录结果映射为自定义目录结构！！
            //默认机制是，模板目录结构与控制器挂件模块等结构保持一致。
            /*
            'theme' => [
                'class' => 'yii\base\Theme',
                //已经在module中设置了，不需要重复设置
                'basePath' => '@app/themes/classic1',//主题所在文件路径
                'baseUrl' => '@app/themes/classic1',//与主题相关的url资源路径
                'pathMap' => [
                    '@app/modules' => '@app/themes/classic',//模块模板
                    '@app/widgets' => '@app/themes/classic1/web/widgets',//部件模板
                    '@app/layouts' => '@app/themes/classic/web/layouts',//内容模板
                    '@app/views' => '@app/themes/classic/web/views',//布局模板
                ],
            ]
            */
        ],
        //前端资源管理
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            //强制更换核心资源的版本，前端兼容性考虑
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@app/assets/jquery/',
                    'js' => [
                        'jquery-1.9.1.min.js'
                    ]
                ],
            ],
        ],
        //异常处理
        'errorHandler' => [
            'class' => 'yii\web\ErrorHandler',
            'errorAction' => 'banjia/site/error',//默认显示pc版路由
        ],
        //伪静态管理
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
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
