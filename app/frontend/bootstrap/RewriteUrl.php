<?php

namespace app\bootstrap;

use Yii;
use yii\base\BootstrapInterface;

class RewriteUrl extends \yii\base\Component implements BootstrapInterface
{
    public function bootstrap($app)
    {
        
    }
    
    /*
    public $defaultLang = 'zh-CN';
    
    public function bootstrap($app)
    {
        //默认语言
        $lang = $this->defaultLang;
        
        //url语言切换
        $url = Yii::$app->request->getUrl();
        foreach (Yii::$app->params['config_sunsult_languages'] as $langKey => $name) {
            if((($pos = strpos($url, '/'.$langKey.'/')) !== false) && $pos === 0) {
                $lang = $langKey;
            }
        }
        
        Yii::$app->language = $lang;//初始化一下系统语言
        
        //正式给到系统待久层
        define('SITE_LANG', $lang);
        
        if(SITE_LANG == $this->defaultLang) {//默认站点规则
            $app->getUrlManager()->addRules([
                //首页
                ['class' => 'yii\web\UrlRule', 'pattern' => 'index', 'route' => 'home/index'],
                //联系我们
                ['class' => 'yii\web\UrlRule', 'pattern' => 'contact/index-<type:([\w._-]+)>', 'route' => 'contact/index'],
                //简单页面
                ['class' => 'yii\web\UrlRule', 'pattern' => 'page-<slug:([\w._-]+)>', 'route' => 'info/detail'],
                //新闻、品牌
                ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(news|brand)>-list-<type:\d+>-<page:\d+>-<per-page:\d+>', 'route' => '<controller>/list'],
                ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(news|brand)>-list-<type:\d+>', 'route' => '<controller>/list'],
                ['class' => 'yii\web\UrlRule', 'pattern' => '<controller:(news|brand)>-detail-<slug:([\w._-]+)>', 'route' => '<controller>/detail'],
                //默认
                ['class' => 'yii\web\UrlRule', 'pattern' => '<controller>/<action>', 'route' => '<controller>/<action>'],
            ], false);
        } else {//多语言规则
            $app->getUrlManager()->addRules([
                //首页
                ['class' => 'yii\web\UrlRule', 'pattern' => SITE_LANG.'/index', 'route' => 'home/index'],
                //联系我们
                ['class' => 'yii\web\UrlRule', 'pattern' => SITE_LANG.'/contact/index-<type:([\w._-]+)>', 'route' => 'contact/index'],
                //简单页面
                ['class' => 'yii\web\UrlRule', 'pattern' => SITE_LANG.'/page-<slug:([\w._-]+)>', 'route' => 'info/detail'],
                //新闻、品牌
                ['class' => 'yii\web\UrlRule', 'pattern' => SITE_LANG.'/<controller:(news|brand)>-list-<type:\d+>-<page:\d+>-<per-page:\d+>', 'route' => '<controller>/list'],
                ['class' => 'yii\web\UrlRule', 'pattern' => SITE_LANG.'/<controller:(news|brand)>-list-<type:\d+>', 'route' => '<controller>/list'],
                ['class' => 'yii\web\UrlRule', 'pattern' => SITE_LANG.'/<controller:(news|brand)>-detail-<slug:([\w._-]+)>', 'route' => '<controller>/detail'],
                //默认
                ['class' => 'yii\web\UrlRule', 'pattern' => SITE_LANG.'/<controller>/<action>', 'route' => '<controller>/<action>'],
            ], false);
        }
    }
    */
}
