<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\bootstrap;

use Yii;

/**
 * 系统初始化生成了全局参数以"config_init_"为前缀
 * 普通的导入类方式
 */
class InitSysten extends \yii\base\Component implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        //
    }
    
    /*
    const INIT_PARAMS = '__init_params';
    const INIT_LAGN = '__init_lang';//切换后的语言session
    
    //默认值
    const DEFAULT_ON = 1;
    const DEFAULT_OFF = 0;
    
    public function bootstrap($app)
    {
        $session = Yii::$app->session;
        
        //手动切换
        if($lang = Yii::$app->request->post('lang')) {
            $session->set(self::INIT_LAGN, $lang);//提交语言
            $session->remove(self::INIT_PARAMS);
            
            //内容+构架，整体刷新
            $session->remove(ReturnUrlFilter::RETURN_RUL_ROUTE);
            Yii::$app->getResponse()->refresh('#lang');
        }
        
        //var_dump($session->get(self::INIT_LAGN));//只负责切换的时候有效，切换完成就删除
        //var_dump($session->get(self::INIT_PARAMS));//用来保存记录，它决定系统的语言数据
        
        //读取历史记录
        if($session->has(self::INIT_PARAMS)) {
            $params = $session->get(self::INIT_PARAMS);
            
            //$params['config_init_langs'];
            //$params['config_init_default_lang'];//保存最终确认的语言
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
        } else {
            $multilangTpls = (new Query())->from(MultilangTpl::tableName())->all();
            $allLang = [];
            $defaultLang = '';
            
            foreach ($multilangTpls as $multilangTpl) {
                if($multilangTpl['back_default']) {
                    $defaultLang = $multilangTpl['lang_sign'];
                }
                $allLang[] = $multilangTpl['lang_sign'];
            }
            
            if(empty($allLang)) {
                throw new InvalidConfigException('系统管理/多语言管理：未设置语言。');
            }
            
            if(empty($defaultLang)) {
                throw new InvalidConfigException('系统管理/多语言管理：未设置默认语言。');
            }
            
            //所有语言+后台默认语言
            $params = [
                'config_init_langs' => $allLang,
                'config_init_default_lang' => $session->has(self::INIT_LAGN)?$session->get(self::INIT_LAGN):$defaultLang,//优先使用动手切换的值
            ];
            
            $session->set(self::INIT_PARAMS, $params);
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);
            
            //==============
            
            //切换完成，切换临时语言清空处理
            $session->remove(self::INIT_LAGN);
            
            //临时生成
            define('GLOBAL_LANG', Yii::$app->params['config_init_default_lang']);
            define('CONFIG_CACHE_KEY', 'sys.cache.'.GLOBAL_LANG);
            
            //清空缓存
            Yii::$app->cache->delete(CONFIG_CACHE_KEY);
        }
        
        defined('GLOBAL_LANG') || define('GLOBAL_LANG', Yii::$app->params['config_init_default_lang']);
        defined('CONFIG_CACHE_KEY') || define('CONFIG_CACHE_KEY', 'sys.cache.'.GLOBAL_LANG);
    }
    */
}