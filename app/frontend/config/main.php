<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */

use frontend\bootstrap\Init;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-frontend',
    'name' => 'Frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'home/default', // 默认路由，后台默认首页
    'layout' => 'main', // 默认布局
    'viewPath' => '@app/themes/classic/views',
    'layoutPath' => '@app/themes/classic/layouts',
    'bootstrap' => [
        'devicedetect',//客户端检测
        [
            'class' => Init::class,//初始化环境：模板、语言、缓存
        ],
    ],
    'modules' => [
        //用户中心模块
        'account' => [
            'class' => 'frontend\modules\account\Module',
            'as access' => [
                'class' => 'frontend\modules\account\filters\AccessFilter',
                'except' => [],//allowAction方法替代了
                'denyCallback' => function ($action) {
                    //fb('未审核嘛');
                }
            ],
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
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect',
        ],
        'user' => [
            'identityClass' => 'common\models\user\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['account/user/login'],
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'app-frontend',
        ],
        'view' => [
            // 主题配置(module目录下的views > 根目录下的views > 主题下的模板)
            'class' => 'frontend\components\View',
            //theme的功能是重新映射的关系，即将原模板系统默认的目录结果映射为自定义目录结构！！
            //默认机制是，模板目录结构与控制器挂件模块等结构保持一致。
            'theme' => [
                'class' => 'yii\base\Theme',//配置了才能初始化
                //已经在module中设置了，不需要重复设置
                'basePath' => '@app/themes/classic',//主题所在文件路径
                'baseUrl' => '@app/themes/classic',//与主题相关的url资源路径
                'pathMap' => [
                    '@app/modules' => '@app/themes/classic/modules',//模板
                    '@app/widgets' => '@app/themes/classic/widgets',//部件
                    '@app/layouts' => '@app/themes/classic/layouts',//布局
                    //优先级最低
                    '@app/views' => '@app/themes/classic',//非模块模板
                ],
            ],
            //'renderers'//定义模板引擎，默认twig
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
            'errorAction' => 'site/error',//默认显示pc版路由
        ],
        //伪静态管理
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],

    'params' => $params,
];


//本地环境下，且在本地启用debug和gii模块
if (YII_DEBUG && !YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'queue' => ['class' => 'yii\queue\debug\Panel'],
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        /*
        'generators' => [//重点，为gii添加新模板
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => ['wind' => '@backend/gii/model/wind']
            ],
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => ['wind' => '@backend/gii/crud/wind']
            ],
            'controller' => [
                'class' => 'yii\gii\generators\controller\Generator',
                'templates' => ['wind' => '@backend/gii/controller/wind']
            ],
            'form' => [
                'class' => 'yii\gii\generators\form\Generator',
                'templates' => ['wind' => '@backend/gii/form/wind']//填写别名路径
            ],
            'module' => ['class' => 'yii\gii\generators\module\Generator'],
            'extension' => ['class' => 'yii\gii\generators\extension\Generator'],
            'queue' => [
                'class' => 'yii\queue\gii\Generator',
                'templates' => ['default' => '@yii/queue/gii/default']
            ],
        ]
        */
    ];
}

return $config;