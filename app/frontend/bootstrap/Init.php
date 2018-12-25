<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\bootstrap;

use Yii;
use common\models\sys\MultilangTpl;
use yii\db\Query;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use common\models\sys\Template;
use common\models\sys\Config;
use yii\caching\TagDependency;

/**
 * 系统初始化生成了全局参数以"config_init_"为前缀
 * 普通的导入类方式
 */
class Init extends \yii\base\Component implements \yii\base\BootstrapInterface
{
    const MULTI_LAGN_CACHE = '__multi_lang_cache';//多语言默认配置参数缓存
    const CURRENT_TEMPLATE_CACHE = '__current_template_cache';//当前模板参数缓存
    
    private $_cache;
    
    //流程化处理，不考虑多个过滤器相互依赖发生作用
    public function bootstrap($app)
    {
        $this->_cache = Yii::$app->cache;
        
        //tag缓存依赖测试用例
        /*
        if($va = $this->_cache->get('abc')) {//使用get可识别依赖，exsit不支持
            //
        } else {
            //依赖缓存
            $va = 'Yii2 - '.time();
            $this->_cache->set('abc', $va, 3600, new TagDependency(['tags' => Yii::$app->params["config.updateAllCache"]]));
        }
        
        echo $va;
        exit;
        */
        
        //1.语言初始化
        $this->initLang();//由确定的当前语言产生的全局常量，用来固化整个系统环境
        
        //2.伪静态处理
        $this->initRewrite();//根据语言定制伪静态
        
        //3.系统缓存
        $this->initConfig();//根据语言获取后台配置参数
        
        //4.模板选择
        $this->initTemplate();//初始化模板系统，并产生一个模板常量
        
        //5.界面缓存
        $this->initFace();//根据模板获取对应的模板配置参数
    }
    
    protected function initLang()
    {
        //读取默认语言设置
        if($params = $this->_cache->get(self::MULTI_LAGN_CACHE)) {//使用get可识别依赖，exsit不支持
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
        } else {
            //依赖缓存
            $params = MultilangTpl::LangList();
            $this->_cache->set(self::MULTI_LAGN_CACHE, $params, 3600, new TagDependency(['tags' => Yii::$app->params["config.updateAllCache"]]));
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
        }
        
        //由数据库设置的前台默认语言，首先运行系统时有效
        $lang = Yii::$app->params['config_init_default_lang'];
        $langKey = Yii::$app->params['config_init_default_lang_key'];
        $tid = Yii::$app->params['config_init_template_id'];
        
        //url获取当前指定的语言
        $url = Yii::$app->request->getUrl();
        foreach (Yii::$app->params['config_init_langs'] as $kk => $ll) {
            if((($pos = strpos($url, '/'.$kk.'/')) !== false) && $pos === 0) {
                $langKey = $kk;
                $lang = $ll['sign'];
                $tid = $ll['tid'];
            }
        }
        
        //设置系统语言
        Yii::$app->language = $lang;
        
        //系统全局生效
        define('GLOBAL_LANG', $lang);//语言包名
        define('GLOBAL_LANG_KEY', $langKey);//语言URL KEY
        define('GLOBAL_TEMPLATE_ID', $tid);//语言包名
        define('GLOBAL_SYS_CACHE_KEY', 'sys.cache.'.GLOBAL_LANG);
        
        //var_dump(GLOBAL_LANG);var_dump(GLOBAL_LANG_KEY);var_dump(GLOBAL_TEMPLATE_ID);var_dump(CONFIG_CACHE_KEY);exit;
    }
    
    protected function initRewrite()
    {
        $urlManager = Yii::$app->urlManager;
        
        //系统必须开启伪静态配置
        $urlManager->enablePrettyUrl = true;//开启url的斜杠拼接模式
        $urlManager->showScriptName = false;//不显示index.php或者xxxx.php
        $urlManager->suffix = '.html';
        
        if(GLOBAL_LANG == Yii::$app->params['config_init_default_lang']) {//默认站点规则
            $urlManager->addRules([
                //首页
                ['class' => 'yii\web\UrlRule', 'pattern' => 'index', 'route' => 'site/home'],
                //联系我们
//                 ['class' => 'yii\web\UrlRule', 'pattern' => 'contact/index-<type:([\w._-]+)>', 'route' => 'contact/index'],
                //简单页面
//                 ['class' => 'yii\web\UrlRule', 'pattern' => 'page-<slug:([\w._-]+)>', 'route' => 'info/detail'],
                //新闻、品牌
//                 ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(news|brand)>-list-<type:\d+>-<page:\d+>-<per-page:\d+>', 'route' => '<controller>/list'],
//                 ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(news|brand)>-list-<type:\d+>', 'route' => '<controller>/list'],
//                 ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(news|brand)>-detail-<slug:([\w._-]+)>', 'route' => '<controller>/detail'],
                //默认
                ['class' => 'yii\web\UrlRule', 'pattern' => '<controller>/<action>', 'route' => '<controller>/<action>'],
            ], false);
        } else {//多语言规则
            $urlManager->addRules([
                //首页
                ['class' => 'yii\web\UrlRule', 'pattern' => GLOBAL_LANG_KEY.'/index', 'route' => 'site/home'],
                //联系我们
//                 ['class' => 'yii\web\UrlRule', 'pattern' => GLOBAL_LANG_KEY.'/contact/index-<type:([\w._-]+)>', 'route' => 'contact/index'],
                //简单页面
//                 ['class' => 'yii\web\UrlRule', 'pattern' => GLOBAL_LANG_KEY.'/page-<slug:([\w._-]+)>', 'route' => 'info/detail'],
                //新闻、品牌
//                 ['class' => 'yii\web\UrlRule', 'pattern' => GLOBAL_LANG_KEY.'/<controller:(news|brand)>-list-<type:\d+>-<page:\d+>-<per-page:\d+>', 'route' => '<controller>/list'],
//                 ['class' => 'yii\web\UrlRule', 'pattern' => GLOBAL_LANG_KEY.'/<controller:(news|brand)>-list-<type:\d+>', 'route' => '<controller>/list'],
//                 ['class' => 'yii\web\UrlRule', 'pattern' => GLOBAL_LANG_KEY.'/<controller:(news|brand)>-detail-<slug:([\w._-]+)>', 'route' => '<controller>/detail'],
                //默认
                ['class' => 'yii\web\UrlRule', 'pattern' => GLOBAL_LANG_KEY.'/<controller>/<action>', 'route' => '<controller>/<action>'],
            ], false);
        }
    }
    
    protected function initConfig()
    {
        Yii::$app->params = ArrayHelper::merge(Yii::$app->params, Config::CacheList());
    }
    
    protected function initTemplate()
    {
        //要使用依赖缓存
        if($template = $this->_cache->get(self::CURRENT_TEMPLATE_CACHE)) {
            //nothing
        } else {
            $template = (new Query())->from(Template::tableName())->where(['temp_id' => GLOBAL_TEMPLATE_ID])->one();
            $this->_cache->set(self::CURRENT_TEMPLATE_CACHE, $template, 3600, new TagDependency(['tags' => Yii::$app->params["config.updateAllCache"]]));
        }
        
        if(empty($template)) {
            throw new InvalidConfigException('系统管理/多语言管理：Id为'.GLOBAL_TEMPLATE_ID.'的模板未找到。');
        }
        
        //设置系统模板
        Yii::$app->setViewPath('@app/themes/'.$template['temp_code'].'/views');
        Yii::$app->setLayoutPath('@app/themes/'.$template['temp_code'].'/layouts');

        $theme = Yii::$app->getView()->theme;
        $theme->basePath = '@app/themes/'.$template['temp_code'];//主题所在文件路径
        $theme->baseUrl = '@app/themes/'.$template['temp_code'];//与主题相关的url资源路径
        $theme->pathMap = [
            '@app/modules' => '@app/themes/'.$template['temp_code'].'/modules',//模板
            '@app/widgets' => '@app/themes/'.$template['temp_code'].'/widgets',//部件
            '@app/layouts' => '@app/themes/'.$template['temp_code'].'/layouts',//布局
            //优先级最低
            '@app/views' => '@app/themes/'.$template['temp_code'],//非模块模板
        ];
    }
    
    protected function initFace()
    {
        
        return true;
    }
}