<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
use app\bootstrap\InitSysten;
use app\bootstrap\InitConfig;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

//配置原则：能在Application、Moudule中配置的，都要在main中配置，谢谢...
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'name' => 'turen2.com',
    'version' => '1.3.0',
    'charset' => 'UTF-8',
    'sourceLanguage' => 'en-US', // 默认源语言
    'language' => 'zh-CN', // 默认当前环境使用的语言
    'controllerNamespace' => 'app\\modules\\site\\controllers',//默认预加载控制器类的命名空间
    'defaultRoute' => 'site/home/index', // 默认路由，后台默认首页
    'layout' => 'main', // 默认布局
    //'viewPath' => '@app/themes/classic',
    //'layoutPath' => '@app/themes/classic/layouts',//View组件中可配配置
    
    //系统初始化时预处理核心组件后，调用此组件的接口bootstrap()方法
    'bootstrap' => [
        'log',
        //'app\bootstrap\initSysten',//php 7.2不支持
        //'app\bootstrap\initConfig',
        [
            'class' => InitSysten::class,//初始化环境：模板、语言、缓存
        ],
        [
            'class' => InitConfig::class,//依据语言进行配置初始化
        ]
    ],
    'modules' => [
        'com' => [//公共服务调用
            'class' => 'app\modules\com\Module',
        ],
        'site' => [//主要解决公共页面的展示，iframe主框架、404、503、首页等
            'class' => 'app\modules\site\Module',
            //'defaultRoute' => 'home/index',//默认进入home控制器，在全局已配置
        ],
        'sys' => [
            'class' => 'app\modules\sys\Module',
        ],
        'cms' => [
            'class' => 'app\modules\cms\Module',
        ],
        'ext' => [
            'class' => 'app\modules\ext\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'shop' => [
            'class' => 'app\modules\shop\Module',
        ],
        'tool' => [
            'class' => 'app\modules\tool\Module',
        ],
    ],
    'components' => [
		'request' => [
            'class' => 'yii\web\Request',
            'cookieValidationKey' => 'OUX1YppF-bHW9cm86EAmg4MwmBQ6Xvni',
            'csrfParam' => '_csrf-backend',
            'enableCsrfValidation' => true,//默认显示csrf验证（前提）
            'enableCsrfCookie' => true,//默认显示了基于cookie的csrf，否则将以session传递验证数据
            'enableCookieValidation' => true,//默认配合上面启用验证
        ],
        'user' => [// 用户持久组件配置
            // 'class' => 'yii\web\User',//默认
            // 身份认证模型
            'identityClass' => 'app\models\sys\Admin',
            // 重点，当开始基于cookie登录时，这个数组就是初始化cookie的值
            // 即专为身份验证的cookie配置专用的cookie对象，以下就是对象的初始化参数，cookie对象已经实现了ArrayIterator操作
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true
            ], // 可以实现如子站点同时登录
            // 是否启用基于cookie的登录，即保持cookie和session的相互恢复，所以它是基于session
            'enableAutoLogin' => true,
            // 是否基于会话，如果是restful，那么隐藏使用无状态验证访问
            'enableSession' => true,
            // 登录的有效时间，也叫验证的有效时间，如果没有设置则以seesion过期时间为准
            // 即，用户在登录状态下未操作的时间间隔有效为authTimeout，超过就退出，Note that this will not work if [[enableAutoLogin]] is true.
            // 并返回超时提示
            'authTimeout' => null,
            // 设置一个绝对的登出时间，过期时间不会自动延期，到点儿就失效
            'absoluteAuthTimeout' => null,
            // 持久层是否延续最新时间，使cookie保持最新
            'autoRenewCookie' => true,
            // 基于loginRequired()，不可为null
            'loginUrl' => [
                '/site/admin/login'
            ],
        
            // 以下是以session来存储相关的参数值的
            'authTimeoutParam' => '__expire', // 过期时间session标识
            'idParam' => '__id', // 用户登录会话id的session标识
            'absoluteAuthTimeoutParam' => '__absolute_expire',
            'returnUrlParam' => '__return_url', // 这个是重点，实现无权访问再登录后跳转到原来的rul，这个url就是__returnUrl，记录在session中
        ],
        'session' => [// session配置
            'class' => 'yii\web\DbSession',//也可以转移到memcache缓存，CacheSession
            'name' => 'turensession',//session name
            'sessionTable' => '{{%session}}',
            'timeout' => 3600, // 超时设置
            /*
            'writeCallback' => function ($session) {
                //回调，把更多的信息存储在了session新的字段中中
                return [
                    'user_id' => Yii::$app->user->id,
                    'ip' => Yii::$app->request->getUserIP(),//$_SERVER['REMOTE_ADDR'],
                    'is_trusted' => $session->get('is_trusted', false),//是否受信任is_trusted，用于风控系统标识
                ];
            }
            */
        ],
        'view' => [
            // 主题配置(module目录下的views > 根目录下的views > 主题下的模板)
            'class' => 'app\components\View',
            'theme' => [
                'class' => 'yii\base\Theme',
                'basePath' => '@app/themes/classic',//主题所在文件路径
                'baseUrl' => '@app/themes/classic',//与主题相关的url资源路径
                'pathMap' => [
                    // 这里可以优先使用指定主题，也可以指定最小单位主题
                    // '@app/views' => [
                        // '@app/themes/default',//替换为default主题
                        // '@app/themes/classic',//默认主题
                    // ],
                    '@app/modules' => '@app/themes/classic/modules',//模板
                    '@app/widgets' => '@app/themes/classic/widgets',//部件
                    '@app/views' => '@app/themes/classic',//布局
                ],
            ],
            //'renderers'//定义模板引擎，默认twig
        ],
        'assetManager' => [//前端资源管理
            'class' => 'yii\web\AssetManager',
            //'linkAssets' => true,//软链接发布资源，即资源一直保持最新，apache要配置为Options FollowSymLinks
            //'appendTimestamp' => true,//资源请求时，加时间戳参数
            //'hashCallback' => function ($path) {
                //"md5", "sha256", "haval160"
                //return hash('crc32', $path.Yii::$app->version);//整合进项目版本号[这里是回调，Yii有效]
            //},
            //强制更换核心资源的版本，配合hplus主题
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@app/assets/jquery/',
                    'js' => [
                        'jquery.min.js'
                    ]
                ],
            ],
        ],
        'log' => [// 不同等级的日志，以不同的方式发给不同的人
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',//发送的Target对象
                    'levels' => ['error', 'warning'],//info可以在开发时做性能优化
                ], 
                //[
                    //'class' => 'yii\log\EmailTarget',//发送邮件
                    //'levels' => ['error', 'warning'],
                    //'message' => [
                        //'from' => ['xiayouqiao@turen.com'],
                        //'to' => ['980522557@qq.com', '19146400@qq.com'],
                        //'subject' => '您有一个新bug，来自erp.turen.com',
                    //],
                //],
                //[
                    //'class' => 'yii\log\DbTarget',//使用数据库记录日志（注意：还可以将文件日志迁移到数据库）
                    //'levels' => ['info', 'error', 'warning']
                //]
            ],
        ],
        // 错误句柄配置
        'errorHandler' => [
            /*
             * 原理：
             * 1.当YII_DEBUG为false时，且没有errorHandler的视图接管，则显示An internal server error occurred.隐藏了所有细节。
             * 2.当YII_DEBUG为false时，有errorHandler的视图接管，则显示结果与此视图相匹配。
             * 3.当YII_DEBUG为true时，且没有errorHandler的视图接管，则显示异常的所有过程。
             * 4.当YII_DEBUG为true时，有errorHandler的视图接管，则显示结果与此视图相匹配。
             * 结论：
             * YII_DEBUG是开启显示异常细节的配置。
             * errorHandler接管只影响显示的方式。
             * 以上两条没有必然关联。
             * 
             * 描述：此异常（错误）句柄的配置，整体考虑到了：用户界面（Prod），开发者界面（Dev），测试界面（Test）
             * 这三种身份需要分别处理相关异常，所以我们在此处配置的是三种身份的错误界面。
             * 1.Prod环境，用户级别只执行errorAction，系统异常执行errorView和exceptionView
             * 2.Dev环境，只执行errorView和exceptionView
             * 3.Test环境，直接返回错误字符串
             * 另外，要认识三者的区别，还需要了解yii系统的异常对象的继承关系，整个系统分为两层：
             * 一是系统级别，即程序运行时因代码或者需要的数据达不到要求抛出的异常。
             * 二是用户级别，即面向用户操作的异常，Exception->UserException->HttpException+InvalidRouteException->...
             * 基本可以认为是，由用户以各种方式发出的请求传入的数据不合理导致的。
             */
            //'displayVars' => ['_GET'],//只显示一个get全局量
            //'memoryReserveSize' => 0,//不预留内存空间
            //'maxSourceLines' => 19,
            //'maxTraceSourceLines' => 13,
            //非debug或者是用户异常时有效，以正常的路由执行来显示错误【用户异常即http请求过程中与用户操作相关的所有http异常】
            'errorAction' => 'site/other/error',
            
            /** 默认配置，这些配置在ErrorAction可以配置！！！
            [errorView] => '@yii/views/errorHandler/error.php'
            [exceptionView] => '@yii/views/errorHandler/exception.php'
            [callStackItemView] => '@yii/views/errorHandler/callStackItem.php'
            [previousExceptionView] => '@yii/views/errorHandler/previousException.php'
            */
        ],
        /*
         * 注意：cache的配置已经在commmon/config.php中配置过了
        'cache' => [// memcache缓存，也可以使用其它的存储驱动，也可以改写组件id，如cache1同时启用多个不同类型的驱动
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        /*
        'catchAll'=>[// 配置维护模式配置（此配置由控制库后台进行管理，写在总控制器中）
             'common/site/offline',//系统维护模式路由
             'title'=>'标题',
             'content'=>'内容说明',
        ],
        */
    ],
    
    //以as 的方式，行为以过滤器的方式被绑定到了App对象上
    /*
    'as init' => [
        'class' => 'app\filters\Filter'
    ],
    */
    //iframe url自动记忆
    'as returnUrl' => [
        'class' => 'app\filters\ReturnUrlFilter',
        'except' => $params['config.autoReturnRoute'],
    ],
    //访问控制
    'as ac' => [
        'class' => 'app\filters\AccessControl',
        'rules' => [],
        'except' => $params['config.notLoginNotaccessRoute'],//排除匹配项，其它都得验证权限

        //'class' => 'app\filters\AcFilter',
        //'except' => $params['config.notLoginNotaccessRoute'],
    ],
    //日志记录
    'as logBehavior' => [
        'class' => 'app\behaviors\LogBehavior',
    ],
    
    'params' => $params,
];


/*
 * 快速查询
以下yii全栈类库，大多数组件都基于工厂模式
yii核心基本运行类：服务于控制台和web
'log' => ['class' => 'yii\log\Dispatcher'],
'view' => ['class' => 'yii\web\View'],
'formatter' => ['class' => 'yii\i18n\Formatter'],
'i18n' => ['class' => 'yii\i18n\I18N'],
'mailer' => ['class' => 'yii\swiftmailer\Mailer'],
'urlManager' => ['class' => 'yii\web\UrlManager'],
'assetManager' => ['class' => 'yii\web\AssetManager'],
'security' => ['class' => 'yii\base\Security'],

yii核心基本运行类：服务于web
'request' => ['class' => 'yii\web\Request'],
'response' => ['class' => 'yii\web\Response'],
'session' => ['class' => 'yii\web\Session'],
'user' => ['class' => 'yii\web\User'],
'errorHandler' => ['class' => 'yii\web\ErrorHandler'],

yii核心可选配置类：
'authManager' => ['class' => 'yii\rbac\DbManager'],
'db' => ['class' => 'yii\db\Connection'],
'mailer' => ['class' => 'yii\swiftmailer\Mailer'],
'cache' => ['class' => 'yii\caching\FileCache'],

小结一下，默认预定义别名一共有12个，其中路径别名11个，URL别名只有 @web 1个：
@yii 表示Yii框架所在的目录，也是 yii\BaseYii 类文件所在的位置
@app 表示正在运行的应用【统指当前应用根目录】的根目录，一般是 xxxxx.com/frontend
@vendor 表示Composer第三方库所在目录，一般是 @app/vendor 或 @app/../vendor
@bower 表示Bower第三方库所在目录，一般是 @vendor/bower
@npm 表示NPM第三方库所在目录，一般是 @vendor/npm
@runtime 表示正在运行的应用的运行时用于存放运行时文件的目录，一般是 @app/runtime
@webroot 表示正在运行的应用的入口文件 index.php 所在的目录，一般是 @app/web
@web URL别名，表示当前应用的根URL，主要用于前端，是一个http目录，如http://baidu.com/web/
@common 表示通用文件夹
@frontend 表示前台应用所在的文件夹
@backend 表示后台应用所在的文件夹
@console 表示命令行应用所在的文件夹
其他使用Composer安装的Yii扩展注册的二级别名。

由上可知，yii兼容有自己的加载方式：
从其运作原理看，最快找到类的方式是使用映射表。
其次，Yii中所有的类名，除了符合规范外，还需要提前注册有效的根别名。
这个原理也是yii拓展开发的原理，通常每个yii拓展都默认配置一个别名....
 */