<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
namespace app\bootstrap;

use Yii;
use yii\base\InvalidConfigException;
use app\models\sys\Template;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\helpers\Json;
use app\filters\ReturnUrlFilter;
use app\models\sys\MultilangTpl;

/**
 * 系统初始化生成了全局参数以"config_init_"为前缀
 * 普通的导入类方式
 */
class InitSysten extends \yii\base\Component implements \yii\base\BootstrapInterface
{
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
            $session->set(self::INIT_LAGN, $lang);
            $session->remove(self::INIT_PARAMS);
            //内容+构架，整体刷新
            Yii::$app->getSession()->remove(ReturnUrlFilter::RETURN_RUL_ROUTE);
            Yii::$app->getResponse()->refresh('#lang');
        } else {
            $session->remove(self::INIT_LAGN);
        }
        
        //读取历史记录
        if($session->has(self::INIT_PARAMS)) {
            $params = $session->get(self::INIT_PARAMS);
            Yii::$app->params = ArrayHelper::merge(Yii::$app->params, $params);//$params['config_init_langs'];//$params['config_init_default_lang'];
        } else {
            $multilangTpls = (new Query())->from(MultilangTpl::tableName())->all();
            $allLang = [];
            $defaultLang = '';
            
            foreach ($multilangTpls as $multilangTpl) {
                if($multilangTpl['back_defautl']) {
                    $defaultLang = $multilangTpl['lang'];
                }
                $allLang[] = $multilangTpl['lang'];
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
        }
        
        define('GLOBAL_LANG', Yii::$app->params['config_init_default_lang']);
        define('CONFIG_CACHE_KEY', 'sys.cache.'.GLOBAL_LANG);
    }
}