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

/**
 * 系统初始化生成了全局参数以"config_init_"为前缀
 * 普通的导入类方式
 */
class Init extends \yii\base\Component implements \yii\base\BootstrapInterface
{
    const MULTI_LAGN_TOGGLE = '__multi_lang_toggle';//多语言切换标记
    const MULTI_LAGN_CACHE = '__multi_lang_cache';//多语言默认配置参数缓存
    
    //默认值
    const DEFAULT_ON = 1;
    const DEFAULT_OFF = 0;
    
    //流程化处理，不考虑多个过滤器相互依赖发生作用
    public function bootstrap($app)
    {
        //1.语言切换
        $this->initLang();
        
        //2.伪静态处理
        $this->initRewrite();
        
        //3.系统缓存
        $this->initConfig();
        
        //4.模板选择
        $this->initTemplate();
        
        //5.界面缓存
        $this->initFace();
        
    }
    
    protected function initLang()
    {
        $cache = Yii::$app->cache;
        
        //读取默认语言设置
        $cache->delete(self::MULTI_LAGN_CACHE);
        if($params = $cache->get(self::MULTI_LAGN_CACHE)) {//使用get可识别依赖，exsit不支持
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
        } else {
            $multilangTpls = (new Query())->from(MultilangTpl::tableName())->all();
            $allLang = [];
            $defaultLang = '';
            $defaultLangKey = '';
            $templateId = '';
            
            foreach ($multilangTpls as $multilangTpl) {
                if($multilangTpl['front_default']) {
                    $defaultLang = $multilangTpl['lang_sign'];//只用来指定系统语言包
                    $defaultLangKey = $multilangTpl['key'];//url key
                    $templateId = $multilangTpl['template_id'];//模板id
                }
                $allLang[$multilangTpl['key']] = [
                    'sign' => $multilangTpl['lang_sign'],
                    'name' => $multilangTpl['lang_name'],
                    'tid' => $multilangTpl['template_id'],
                ];
            }
            
            if(empty($allLang)) {
                throw new InvalidConfigException('系统管理/多语言管理：未设置语言。');
            }
            
            if($defaultLang === '') {
                throw new InvalidConfigException('系统管理/多语言管理：未设置默认语言包。');
            }
            
            if($defaultLangKey === '') {
                throw new InvalidConfigException('系统管理/多语言管理：未设置默认语言key。');
            }
            
            if($templateId === '') {
                throw new InvalidConfigException('系统管理/多语言管理：未设置站点模板。');
            }
            
            //所有语言+前台默认语言
            $params = [
                'config_init_langs' => $allLang,
                'config_init_default_lang' => $defaultLang,
                'config_init_default_lang_key' => $defaultLangKey,
                'config_init_template_id' => $templateId,
            ];
            
            //要使用依赖缓存
            //$dependency = new \yii\caching\ExpressionDependency();
            $cache->set(self::MULTI_LAGN_CACHE, $params);
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
        }
        
        //Yii::$app->params['config_init_langs']
        //Yii::$app->params['config_init_default_lang']
        //Yii::$app->params['config_init_default_lang_key']
        //Yii::$app->params['config_init_template_id']
        
        //由数据库设置的前台默认语言，首先运行系统时有效
        $lang = Yii::$app->params['config_init_default_lang'];
        $langKey = Yii::$app->params['config_init_default_lang_key'];
        $tid = Yii::$app->params['config_init_template_id'];
        
        //url语言切换
        $url = Yii::$app->request->getUrl();
        foreach (Yii::$app->params['config_init_langs'] as $kk => $ll) {
            if((($pos = strpos($url, '/'.$kk.'/')) !== false) && $pos === 0) {
                $langKey = $kk;
                $lang = $ll['sign'];
                $tid = $ll['tid'];
            }
        }
        
        //初始化一下系统语言
        Yii::$app->language = $lang;
        
        //系统全局生效
        define('GLOBAL_LANG', $lang);//语言包名
        define('GLOBAL_LANG_KEY', $langKey);//语言URL KEY
        define('GLOBAL_TEMPLATE_ID', $tid);//语言包名
        
        //var_dump(GLOBAL_LANG);var_dump(GLOBAL_LANG_KEY);var_dump(GLOBAL_TEMPLATE_ID);exit;
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
        
        return true;
    }
    
    protected function initTemplate()
    {
        //要使用依赖缓存
        $template = (new Query())->from(Template::tableName())->where(['temp_id' => GLOBAL_TEMPLATE_ID])->one();
        
        if(empty($template)) {
            throw new InvalidConfigException('系统管理/多语言管理：Id为'.GLOBAL_TEMPLATE_ID.'的模板未找到。');
        }
        
        //设置系统模板
        Yii::$app->setViewPath('@app/themes/'.$template['temp_code'].'/views');
        Yii::$app->setLayoutPath('@app/themes/'.$template['temp_code'].'/layouts');
    }
    
    protected function initFace()
    {
        
        return true;
    }
    
    /*
     public function bootstrap($app)
     {
     //后台管理参数配置
     Yii::$app->params = ArrayHelper::merge(Yii::$app->params, Config::CacheList());
     }
     */
}